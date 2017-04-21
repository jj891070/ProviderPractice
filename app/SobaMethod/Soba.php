<?php
namespace App\SobaMethod;
/**
*
*/
class Soba
{
	/*
	function __construct()
	{
		# code...
	}

  public function sobaRefreshWithEventName()
  {

  }
*/
  public function sobaRefreshMarket($version_key,$eventData)
  {
        $ch=curl_init();
        $options = array(
                   CURLOPT_URL            => 'http://192.168.113.7:8086/api/GetMarkets',
                   CURLOPT_POST           => true,
                   CURLOPT_POSTFIELDS     => 'vendor_id=jP8MMqgExP0&sport_type=1&market_type=t&market_version_key='.$version_key,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_USERAGENT      => "Google Bot",
        );
        curl_setopt_array($ch, $options);
        $original=curl_exec($ch);
        curl_close($ch);
       
        //取EventID,BetType,MarketStatus,Selections
        $updateMarkets = json_decode($original, true);
        $version_key=$updateMarkets['Data'];
        $version_key=$version_key['market_version_key'];
        $updateMarkets = collect($updateMarkets['Data']['markets']);
        $updateMarkets = $updateMarkets->map(function ($value, $key) {
          return [
            'EventID' => $value['EventID'],
            'BetType' => $value['BetType'],
            'MarketStatus' => $value['MarketStatus'],
            'Selections' => $value['Selections'],
          ];
        });
        //取出有更新過的event_id放進event_id2
        /*event_id2[0]=array number
          event_id2[1]=event_id*/
        $event_id=[];
        foreach ($updateMarkets as $key => $value) {
          $event_id[$key]=$value['EventID'];
        }
        $event_id=collect($event_id);
        $event_id=$event_id->unique();
        $num=0;

        for ($i=0; $i <count($eventData) ; $i++) { 
          $id=$eventData[$i]->event_id;
          foreach ($event_id as $key => $value) {
            if($id==$value){
              $event_id2[0][$num]=$i;
              $event_id2[1][$num]=$value;
              $num++;
            }
          }
        }
        if(empty($event_id2)){$event_id2=null;}
        //-----------end------------//
        $odd=[];
        $this->filterMarket($odd,$eventData,$updateMarkets);
        $odd[3]=$event_id2;
        $odd[4]=$version_key;
        return $odd;
        //------------end-------------//
  }

	public function sobaInitEvent()
  {
          $ch=curl_init();
          $options = array(
                   CURLOPT_URL            => 'http://192.168.113.7:8086/api/GetEvents',
                   CURLOPT_POST           => true,
                   CURLOPT_POSTFIELDS     => 'vendor_id=jP8MMqgExP0&sport_type=1&market_type=t',
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_USERAGENT      => "Google Bot",
          );
          //original=GetEvent的頁面原始碼//
          curl_setopt_array($ch, $options);
          $original=curl_exec($ch);
          curl_close($ch);
          //------------end-------------//
          //取EventID,LeagueID，HomeID，AwayID
          $eventData=[];
          $events = json_decode($original, true);
          $version_key=$events['Data'];
          $version_key=$version_key['event_version_key'];
          $events = collect($events['Data']['events']);
          $events = $events->map(function ($value, $key) {
            return [
              'EventID' => $value['EventID'],
              'LeagueID' => $value['LeagueID'],
              'HomeID' => $value['HomeID'],
              'AwayID' => $value['AwayID'],
            ];
          });

          //取球隊及聯賽名稱//
          for ($i=0; $i <count($events) ; $i++) {
          	$eventData[0][$i]=$events[$i]['EventID'];
            $ch3=curl_init();
            $options3 = array(
                     CURLOPT_URL            => 'http://192.168.113.7:8086/api/GetLeagueName',
                     CURLOPT_POST           => true,
                     CURLOPT_POSTFIELDS     => 'vendor_id=jP8MMqgExP0&league_id='.$events[$i]['LeagueID'],
                     CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_USERAGENT      => "Google Bot",
            );
            curl_setopt_array($ch3, $options3);
            $original=curl_exec($ch3);
            //dd($original);
            curl_close($ch3);
            preg_match_all('(\"lang\":\"ch\",\"name\":\".*?\")',$original,$eventData[1][$i]);
            $eventData[1][$i]=preg_replace('(\"lang\":\"ch\",\"name\":\")','',$eventData[1][$i][0][0]);
            $eventData[1][$i]=preg_replace('(\")','',$eventData[1][$i]);
            //------------------------------------------
            $ch3=curl_init();
            $options3 = array(
                     CURLOPT_URL            => 'http://192.168.113.7:8086/api/GetTeamName',
                     CURLOPT_POST           => true,
                     CURLOPT_POSTFIELDS     => 'vendor_id=jP8MMqgExP0&team_id='.$events[$i]['HomeID'],
                     CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_USERAGENT      => "Google Bot",
            );
            curl_setopt_array($ch3, $options3);
            $original=curl_exec($ch3);
            curl_close($ch3);
            preg_match_all('(\"lang\":\"ch\",\"name\":\".*?\")',$original,$eventData[2][$i]);
            $eventData[2][$i]=preg_replace('(\"lang\":\"ch\",\"name\":\")','',$eventData[2][$i][0][0]);
            $eventData[2][$i]=preg_replace('(\")','',$eventData[2][$i]);

            //------------------------------------------
            $ch3=curl_init();
            $options3 = array(
                     CURLOPT_URL            => 'http://192.168.113.7:8086/api/GetTeamName',
                     CURLOPT_POST           => true,
                     CURLOPT_POSTFIELDS     => 'vendor_id=jP8MMqgExP0&team_id='.$events[$i]['AwayID'],
                     CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_USERAGENT      => "Google Bot",
            );
            curl_setopt_array($ch3, $options3);
            $original=curl_exec($ch3);
            curl_close($ch3);
            preg_match_all('(\"lang\":\"ch\",\"name\":\".*?\")',$original,$eventData[3][$i]);
            $eventData[3][$i]=preg_replace('(\"lang\":\"ch\",\"name\":\")','',$eventData[3][$i][0][0]);
            $eventData[3][$i]=preg_replace('(\")','',$eventData[3][$i]);
          }
          $eventData[4]=$version_key;
          //dd($eventData);
          return $eventData;
  }

  public function sobaInitMarket($eventData)
  {

        $ch=curl_init();
        $options = array(
                   CURLOPT_URL            => 'http://192.168.113.7:8086/api/GetMarkets',
                   CURLOPT_POST           => true,
                   CURLOPT_POSTFIELDS     => 'vendor_id=jP8MMqgExP0&sport_type=1&market_type=t',
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_USERAGENT      => "Google Bot",
        );
        curl_setopt_array($ch, $options);
        $original=curl_exec($ch);
        curl_close($ch);

        //取EventID,BetType,MarketStatus,Selections
        $markets = json_decode($original, true);
        $version_key=$markets['Data'];
        $version_key=$version_key['market_version_key'];
        $markets = collect($markets['Data']['markets']);
        $markets = $markets->map(function ($value, $key) {
          return [
            'EventID' => $value['EventID'],
            'BetType' => $value['BetType'],
            'MarketStatus' => $value['MarketStatus'],
            'Selections' => $value['Selections'],
          ];
        });

        //------------end-------------//

        $odd=[];
        $this->filterMarket($odd,$eventData,$markets);
        $odd[3]=$version_key;
        //dd($odd);
        return $odd;
  }

  public function filterMarket(&$odd,&$eventData,$markets)//(輸出,依event的event_id下去分類,抓取到的原始碼)
  {
      for ($i=0; $i < count($eventData); $i++) {
              $tmp_markets=$markets->where('EventID',$eventData[$i]->event_id);

              //---------------------讓分---------------------
              $tmp_markets_bettype=$tmp_markets->where('BetType',1);
              if ($tmp_markets_bettype->isempty()) {
                $odd[0][0][$i]=null;
              }else{
                foreach ($tmp_markets_bettype as $key => $tmp_market_bettype) {
                  $BetType=$tmp_market_bettype['Selections'];
                }
                $BetType=collect($BetType);
                $odd[0][0][$i][0]=$BetType[0]['Price'];//主隊賠率
                $odd[0][0][$i][1]=$BetType[0]['Point'];//主隊球投
                $odd[0][0][$i][2]=$BetType[1]['Price'];//客隊賠率
              }
              //------------------------------------------
              $tmp_markets_bettype=$tmp_markets->where('BetType',7);
              if ($tmp_markets_bettype->isempty()) {
                $odd[0][1][$i]=null;
              }else{
                foreach ($tmp_markets_bettype as $key => $tmp_market_bettype) {
                  $BetType=$tmp_market_bettype['Selections'];
                }
                $BetType=collect($BetType);
                $odd[0][1][$i][0]=$BetType[0]['Price'];//主隊賠率
                $odd[0][1][$i][1]=$BetType[0]['Point'];//主隊球投
                $odd[0][1][$i][2]=$BetType[1]['Price'];//客隊賠率
              }
              //---------------------大小---------------------
              $tmp_markets_bettype=$tmp_markets->where('BetType',3);
              if ($tmp_markets_bettype->isempty()) {
                $odd[1][0][$i]=null;
              }else{
                foreach ($tmp_markets_bettype as $key => $tmp_market_bettype) {
                  $BetType=$tmp_market_bettype['Selections'];
                }
                $BetType=collect($BetType);
                $odd[1][0][$i][0]=$BetType[0]['Price'];//主隊賠率
                $odd[1][0][$i][1]=$BetType[0]['Point'];//主隊球投
                $odd[1][0][$i][2]=$BetType[1]['Price'];//客隊賠率
              }
              //------------------------------------------
              $tmp_markets_bettype=$tmp_markets->where('BetType',8);
              if ($tmp_markets_bettype->isempty()) {
                $odd[1][1][$i]=null;
              }else{
                foreach ($tmp_markets_bettype as $key => $tmp_market_bettype) {
                  $BetType=$tmp_market_bettype['Selections'];
                }
                $BetType=collect($BetType);
                $odd[1][1][$i][0]=$BetType[0]['Price'];//主隊賠率
                $odd[1][1][$i][1]=$BetType[0]['Point'];//主隊球投
                $odd[1][1][$i][2]=$BetType[1]['Price'];//客隊賠率
              }
              //---------------------1*2---------------------
              $tmp_markets_bettype=$tmp_markets->where('BetType',5);
              if ($tmp_markets_bettype->isempty()) {
                $odd[2][0][$i]=null;
              }else{
                foreach ($tmp_markets_bettype as $key => $tmp_market_bettype) {
                  $BetType=$tmp_market_bettype['Selections'];
                }
                $BetType=collect($BetType);
                $odd[2][0][$i][0]=$BetType[0]['Price'];//主隊賠率
                $odd[2][0][$i][1]=$BetType[2]['Price'];//客隊賠率
                $odd[2][0][$i][2]=$BetType[1]['Price'];//和局賠率

              }
              //------------------------------------------
              $tmp_markets_bettype=$tmp_markets->where('BetType',15);
              if ($tmp_markets_bettype->isempty()) {
                $odd[2][1][$i]=null;
              }else{
                foreach ($tmp_markets_bettype as $key => $tmp_market_bettype) {
                  $BetType=$tmp_market_bettype['Selections'];
                }
                $BetType=collect($BetType);
                $odd[2][1][$i][0]=$BetType[0]['Price'];//主隊賠率
                $odd[2][1][$i][1]=$BetType[2]['Price'];//客隊賠率
                $odd[2][1][$i][2]=$BetType[1]['Price'];//和局賠率
              }

          }
  }


}
