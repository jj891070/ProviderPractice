<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Soba;
use Mabo;
use App\OddEvent as OddEvent;
use App\OddMarket as OddMarket;
use App\OddMabo as OddMabo;
class ActController extends Controller
{
    //
    public function sobaIndex()
    {
     
       set_time_limit(0);//設定網頁timeout的時間無限大
       $this->maboMarket();
       //$this->sobaMarketRefresh();
       OddEvent::truncate();
       OddMarket::truncate();
       $this->sobaEvent();
       $this->sobaMarket();
       $data=OddEvent::all();
       return view('soba',['datas'=>$data]);
       //dd(time() - strtotime($event->updated_at));  2631333149
    }
    public function maboIndex()
    {
       OddMabo::truncate();
       $json=$this->maboMarket();
       $data=OddMabo::all();
       return view('mabo',['datas'=>$data]);
    }
    public function maboMarket()
    {
        $sobaEvent=OddEvent::all();
        $odd=Mabo::maboInitMarket($sobaEvent);
        //dd($odd);
        for ($i=0; $i < count($odd); $i++){
          $marketData=new OddMabo();
          $marketData->event_id=$odd[$i]['event_id'];
          $marketData->normal_h=$odd[$i]['normal_h'][0];
          $marketData->normal_a=$odd[$i]['normal_a'][0];
          $marketData->normal_s=$odd[$i]['normal_s'][0];
          $marketData->normal_first_h=$odd[$i]['normal_first_h'][0];
          $marketData->normal_first_a=$odd[$i]['normal_first_a'][0];
          $marketData->normal_first_s=$odd[$i]['normal_first_s'][0];
          $marketData->save();
        }
        
        return $odd;
      
    }
    public function maboMarketRefresh()
    {
      $json=$this->maboMarket();
      return response()->json($json); 
    }


    public function sobaMarketRefresh()
    {
       $json=[];
       $marketData=OddMarket::all();
       $eventData=OddEvent::all();
       $refreshMarket=Soba::sobaRefreshMarket($marketData[0]->key_version,$eventData);
       if($refreshMarket!=null&&$refreshMarket[4]!=null){
           OddMarket::where('key_version',$marketData[0]->key_version)->update(['key_version'=>$refreshMarket[4]]);
           for ($i=0; $i < count($refreshMarket[3][1]); $i++){
              $dbId=$refreshMarket[3][1][$i];//也是等於實際的eventid
              $arrrayId=$refreshMarket[3][0][$i];
              
              if($refreshMarket[0][0][$arrrayId]!=null){
                OddMarket::where('event_id',$dbId)->update(['Handicap_hp' => $refreshMarket[0][0][$arrrayId][0]]);
                OddMarket::where('event_id',$dbId)->update(['Handicap_hh' => $refreshMarket[0][0][$arrrayId][1]]);
                OddMarket::where('event_id',$dbId)->update(['Handicap_ap' => $refreshMarket[0][0][$arrrayId][2]]);
                $json[$i]['Handicap'] = [
                  'id'=>$dbId,
                  'hp'=>$refreshMarket[0][0][$arrrayId][0],
                  'hh'=>$refreshMarket[0][0][$arrrayId][1],
                  'ap'=>$refreshMarket[0][0][$arrrayId][2],
                ];
              }
              if($refreshMarket[0][1][$arrrayId]!=null){
                OddMarket::where('event_id',$dbId)->update(['Handicap_first_hp' => $refreshMarket[0][1][$arrrayId][0]]);
                OddMarket::where('event_id',$dbId)->update(['Handicap_first_hh' => $refreshMarket[0][1][$arrrayId][1]]);
                OddMarket::where('event_id',$dbId)->update(['Handicap_first_ap' => $refreshMarket[0][1][$arrrayId][2]]);
                $json[$i]['Handicap_first'] = [
                  'id'=>$dbId,
                  'hp'=>$refreshMarket[0][1][$arrrayId][0],
                  'hh'=>$refreshMarket[0][1][$arrrayId][1],
                  'ap'=>$refreshMarket[0][1][$arrrayId][2],
                ];
              }
              if($refreshMarket[1][0][$arrrayId]!=null){
                OddMarket::where('event_id',$dbId)->update(['over_hp' => $refreshMarket[1][0][$arrrayId][0]]);
                OddMarket::where('event_id',$dbId)->update(['over_hh' => $refreshMarket[1][0][$arrrayId][1]]);
                OddMarket::where('event_id',$dbId)->update(['over_ap' => $refreshMarket[1][0][$arrrayId][2]]);
                $json[$i]['over'] = [
                  'id'=>$dbId,
                  'hp'=>$refreshMarket[1][0][$arrrayId][0],
                  'hh'=>$refreshMarket[1][0][$arrrayId][1],
                  'ap'=>$refreshMarket[1][0][$arrrayId][2],
                ];
              }
              if($refreshMarket[1][1][$arrrayId]!=null){
                OddMarket::where('event_id',$dbId)->update(['over_first_hp' => $refreshMarket[1][1][$arrrayId][0]]);
                OddMarket::where('event_id',$dbId)->update(['over_first_hh' => $refreshMarket[1][1][$arrrayId][1]]);
                OddMarket::where('event_id',$dbId)->update(['over_first_ap' => $refreshMarket[1][1][$arrrayId][2]]);
                $json[$i]['over_first'] = [
                  'id'=>$dbId,
                  'hp'=>$refreshMarket[1][1][$arrrayId][0],
                  'hh'=>$refreshMarket[1][1][$arrrayId][1],
                  'ap'=>$refreshMarket[1][1][$arrrayId][2],
                ];
              }
              if($refreshMarket[2][0][$arrrayId]!=null){
                OddMarket::where('event_id',$dbId)->update(['normal_h' => $refreshMarket[2][0][$arrrayId][0]]);
                OddMarket::where('event_id',$dbId)->update(['normal_a' => $refreshMarket[2][0][$arrrayId][1]]);
                OddMarket::where('event_id',$dbId)->update(['normal_s' => $refreshMarket[2][0][$arrrayId][2]]);
                $json[$i]['normal'] = [
                  'id'=>$dbId,
                  'h'=>$refreshMarket[2][0][$arrrayId][0],
                  'a'=>$refreshMarket[2][0][$arrrayId][1],
                  's'=>$refreshMarket[2][0][$arrrayId][2],
                ];
              }
              if($refreshMarket[2][1][$arrrayId]!=null){
                OddMarket::where('event_id',$dbId)->update(['normal_first_h' => $refreshMarket[2][1][$arrrayId][0]]);
                OddMarket::where('event_id',$dbId)->update(['normal_first_a' => $refreshMarket[2][1][$arrrayId][1]]);
                OddMarket::where('event_id',$dbId)->update(['normal_first_s' => $refreshMarket[2][1][$arrrayId][2]]);
                $json[$i]['normal_first'] = [
                  'id'=>$dbId,
                  'h'=>$refreshMarket[2][1][$arrrayId][0],
                  'a'=>$refreshMarket[2][1][$arrrayId][1],
                  's'=>$refreshMarket[2][1][$arrrayId][2],
                ];
              }
           }
         
       }
      return response()->json($json); 
    }
    public function sobaEvent()
    {
       $eventName=Soba::sobaInitEvent();
       for ($i=0; $i < count($eventName[0]); $i++) { 
	       	$eventData=new OddEvent();
	       	$eventData->event_id=$eventName[0][$i];
	       	$eventData->league_name=$eventName[1][$i];
	       	$eventData->home_name=$eventName[2][$i];
	       	$eventData->away_name=$eventName[3][$i];
          $eventData->key_version=$eventName[4];
	       	$eventData->save();

       }
       
    }
    public function sobaMarket()
    {
    	$eventData=OddEvent::all();
    	$odd=Soba::sobaInitMarket($eventData);
      for ($i=0; $i < count($eventData); $i++) { 
        $marketData=new OddMarket();
        $marketData->event_id=$eventData[$i]->event_id;
        $marketData->Handicap_hp=$odd[0][0][$i][0];
        $marketData->Handicap_hh=$odd[0][0][$i][1];
        $marketData->Handicap_ap=$odd[0][0][$i][2];
        $marketData->Handicap_first_hp=$odd[0][1][$i][0];
        $marketData->Handicap_first_hh=$odd[0][1][$i][1];
        $marketData->Handicap_first_ap=$odd[0][1][$i][2];
        $marketData->over_hp=$odd[1][0][$i][0];
        $marketData->over_hh=$odd[1][0][$i][1];
        $marketData->over_ap=$odd[1][0][$i][2];
        $marketData->over_first_hp=$odd[1][1][$i][0];
        $marketData->over_first_hh=$odd[1][1][$i][1];
        $marketData->over_first_ap=$odd[1][1][$i][2];
        $marketData->normal_h=$odd[2][0][$i][0];
        $marketData->normal_a=$odd[2][0][$i][1];
        $marketData->normal_s=$odd[2][0][$i][2];
        $marketData->normal_first_h=$odd[2][1][$i][0];
        $marketData->normal_first_a=$odd[2][1][$i][1];
        $marketData->normal_first_s=$odd[2][1][$i][2];
        $marketData->key_version=$odd[3];
        $marketData->save();
      }

    }
}
