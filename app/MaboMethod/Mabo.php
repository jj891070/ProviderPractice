<?php
namespace App\MaboMethod;
/**
*
*/
class Mabo
{
	public function maboInitMarket(&$sobaEvent)
    {
        $maboOdd=$this->catch($sobaEvent);
        return $maboOdd;
    }
    public function catch(&$sobaEvent)
    {
        $ch=curl_init();
        $options = array(
                 CURLOPT_URL            => 'https://www.marathonbet.com/tw/popular/Football/?menu=11',
                 //CURLOPT_POST           => true,
                 //CURLOPT_POSTFIELDS     => $input,
                 //CURLOPT_HEADER         => $header,
                 CURLOPT_RETURNTRANSFER => true,
                 CURLOPT_USERAGENT      => "Google Bot",
                 //CURLOPT_SSL_VERIFYHOST => 0,
                 //CURLOPT_SSL_VERIFYPEER => 0,


        );
        curl_setopt_array($ch, $options);
        $original=curl_exec($ch);
        curl_close($ch);
        $original=str_replace(array("\r","\t","\n"),'',$original);

        //--------------------賽事名稱(可直接抓)--------------------
        preg_match_all('(data-event-name=\".*?\")',$original,$maboEventData);
        $maboEventData=preg_replace('/data-event-name=\"/','',$maboEventData[0]);
        $maboEventData=preg_replace('/\"/','',$maboEventData);
        //dd($maboEventData);
        //----------------------------end---------------------------
        //--------------------判斷soba的event與mabo的event有哪幾筆是一樣的--------------------
        $valid=[];
        $num=0;
        $maboMarketData=[];
        $maboOdd=[];
        $tmp='';
        for ($i=0; $i <count($sobaEvent) ; $i++) {
            $home=$sobaEvent[$i]->home_name;
            $away=$sobaEvent[$i]->away_name;
            for ($j=0; $j <count($maboEventData); $j++) {
                $valid1 = str_contains($maboEventData[$j],$home);
                $valid2 = str_contains($maboEventData[$j],$away);
                if($valid1==true||$valid2==true){
                    $valid[0][$num]=$i;
                    $valid[1][$num]=$sobaEvent[$i]->event_id;
                    preg_match_all('(data-event-name=\"'.$maboEventData[$j].'\".*?<\/tbody>)',$original,$maboMarketData[0][$i]);
                    $maboOdd[$num]['event_id']=$valid[1][$num];
                    preg_match_all('(Match_Result.1\">[0-9]+\.[0-9]+)',$maboMarketData[0][$i][0][0],$tmp);
                    $tmp=preg_replace('/Match_Result.1\">/','',$tmp[0]);
                    $maboOdd[$num]['normal_h']=$tmp[0];

                    preg_match_all('(Match_Result.3\">[0-9]+\.[0-9]+)',$maboMarketData[0][$i][0][0],$tmp);
                    $tmp=preg_replace('/Match_Result.3\">/','',$tmp[0]);
                    $maboOdd[$num]['normal_a']=$tmp[0];

                    preg_match_all('(Match_Result.draw\">[0-9]+\.[0-9]+)',$maboMarketData[0][$i][0][0],$tmp);
                    $tmp=preg_replace('/Match_Result.draw\">/','',$tmp[0]);
                    $maboOdd[$num]['normal_s']=$tmp[0];

                    preg_match_all('(M2087270759mainRow" class="  asian-market-view.*? ")',$maboMarketData[0][$i][0][0],$tmp);
                    if(!str_contains($tmp[0][0],'view-off')){
                        
                        preg_match_all('(Result_-_1st_Half.RN_H\">[0-9]+\.[0-9]+)',$maboMarketData[0][$i][0][0],$tmp);
                        $tmp=preg_replace('/Result_-_1st_Half.RN_H\">/','',$tmp[0]);
                        $maboOdd[$num]['normal_first_h']=$tmp[0];
                        
                        preg_match_all('(Result_-_1st_Half.RN_A\">[0-9]+\.[0-9]+)',$maboMarketData[0][$i][0][0],$tmp);
                        $tmp=preg_replace('/Result_-_1st_Half.RN_A\">/','',$tmp[0]);
                        $maboOdd[$num]['normal_first_a']=$tmp[0];
                        
                        preg_match_all('(Result_-_1st_Half.RN_D\">[0-9]+\.[0-9]+)',$maboMarketData[0][$i][0][0],$tmp);
                        $tmp=preg_replace('/Result_-_1st_Half.RN_D\">/','',$tmp[0]);
                        $maboOdd[$num]['normal_first_s']=$tmp[0];
                    }


                    //dd($maboOdd);
                    $num++;
                    break;
                }
            }
        }
        //dd($maboOdd);
        return $maboOdd;
        //----------------------------end---------------------------
        //--------------------抓取需要的原始碼--------------------

        //----------------------------end---------------------------
        /*
        //--------------------全場1*2(可直接抓)--------------------
        preg_match_all('(Match_Result.1\">[0-9]+\.[0-9]+)',$original,$maboData[1]);
        $maboData[1]=preg_replace('/Match_Result.1\">/','',$maboData[1][0]);

        preg_match_all('(Match_Result.3\">[0-9]+\.[0-9]+)',$original,$maboData[2]);
        $maboData[2]=preg_replace('/Match_Result.3\">/','',$maboData[2][0]);

        preg_match_all('(Match_Result.draw\">[0-9]+\.[0-9]+)',$original,$maboData[3]);
        $maboData[3]=preg_replace('/Match_Result.draw\">/','',$maboData[3][0]);
        //--------------------半場1*2--------------------
        preg_match_all('(Result_-_1st_Half.RN_H\">[0-9]+\.[0-9]+)',$original,$maboData[4]);
        $maboData[4]=preg_replace('/Result_-_1st_Half.RN_H\">/','',$maboData[4][0]);

        preg_match_all('(Result_-_1st_Half.RN_A\">[0-9]+\.[0-9]+)',$original,$maboData[5]);
        $maboData[5]=preg_replace('/Result_-_1st_Half.RN_A\">/','',$maboData[5][0]);

        preg_match_all('(Result_-_1st_Half.RN_D\">[0-9]+\.[0-9]+)',$original,$maboData[6]);
        $maboData[6]=preg_replace('/Result_-_1st_Half.RN_D\">/','',$maboData[6][0]);
        //--------------------半場1*2--------------------
        //preg_match_all('(Match_Result.draw\">[0-9]+\.[0-9]+)',$original,$maboData[3]);
        //$maboData[3]=preg_replace('/Match_Result.1\">/','',$maboData[3][0]);
        */
        $aa[0]=$maboData[1];
        $aa[1]=$maboData[4];
        dd($aa);
	}
}
