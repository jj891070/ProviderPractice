<!DOCTYPE html>
<html>
  <head>
    <style>
        table, td, th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 15px;
        }
        tr:hover{background-color:#f5f5f5}
        
    </style>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="900">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <title>ShowOdds</title>
  </head>

  <body>
     
               <div>
                  <div><input type="button" style="background-color:blue;color:white;" value="Refresh Page" onClick="window.location.reload()"></div>
                  <div align="right">
                  <a href="catch">沙巴</a>|<a href="catch2">馬博</a>
                  <button style="font-size:10px;background-color: #4CAF50" onClick="refresh()"> <i class="material-icons">autorenew</i></button>
               </div>
                  
              </div>
              
              <div>
                  <table>
                      <thead>
                         <tr>
                           <th>赛事</th>
                           <th>全場讓球</th>
                           <th>上半場讓球</th>
                           <th>全場大/小</th>
                           <th>上半場大/小</th>
                           <th>全場標準</th>
                           <th>上半場標準</th>
                         <tr>
                      </thead>
                      <tbody>
                         <!--輸出data資料-->
                         <?php $leagueId="" ?>
                         @foreach ($datas as $key => $data) 
                            <!--輸出league_name-->
                            @if($data->league_name!=$leagueId)
                              <tr>
                                 <td colspan="8">
                                    <span style="color:blue;font-weight:bold">{{$data->league_name}}</span>
                                 </td>
                              </tr>
                            @endif
                            <?php $leagueId=$data->league_name ?>
                            <!--輸出data裡的所有-->
                            <tr>
                              <td>
                                <?php if($data->oddmarket->Handicap_hh<0):?>
                                  <div><span style="color:red;font-weight:bold">{{$data->home_name}}</span></div>
                                  <div>{{$data->away_name}}</div>
                                <?php elseif($data->oddmarket->Handicap_hh==0):?>
                                  <div>{{$data->home_name}}</div>
                                  <div>{{$data->away_name}}</div>
                                <?php else:?>
                                  <div>{{$data->home_name}}</div>
                                  <div><span style="color:red;font-weight:bold">{{$data->away_name}}</span></div>
                                <?php endif;?>
                              </td>
                              <!--輸出data裡的所有賠率資料-->
                              <td>
                                <!--全場讓球-->
                                <div id="Handicap{{$data->event_id}}">
                                  <?php if($data->oddmarket->Handicap_hh<0):?>
                                       <?php
                                         $Handicap_hh=abs($data->oddmarket->Handicap_hh);
                                         $point=$Handicap_hh*10;
                                       ?>
                                       <?php if($point%5!=0):?>
                                          <?php 
                                            $OutPoint1=$Handicap_hh;
                                            $OutPoint2=$Handicap_hh;
                                            $OutPoint1=$OutPoint1-0.25;
                                            $OutPoint2=$OutPoint2+0.25;
                                          ?>
                                          <div align="right" id="Handicap_h{{$data->event_id}}">{{$OutPoint1}}-{{$OutPoint2}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_hp}}</div>
                                          <div align="right" id="Handicap_a{{$data->event_id}}">{{$data->oddmarket->Handicap_ap}}</div>
                                       <?php else:?>
                                          <div align="right" id="Handicap_h{{$data->event_id}}">{{$Handicap_hh}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_hp}}</div>
                                          <div align="right" id="Handicap_a{{$data->event_id}}">{{$data->oddmarket->Handicap_ap}}</div>
                                       <?php endif;?>
                                  <?php elseif($data->oddmarket->Handicap_hh==0):?>
                                       <div align="right" id="Handicap_h{{$data->event_id}}">{{$data->oddmarket->Handicap_hh}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_hp}}</div>
                                       <div align="right" id="Handicap_a{{$data->event_id}}">{{$data->oddmarket->Handicap_ap}}</div>
                                  <?php else:?>
                                       <?php
                                         $point=$data->oddmarket->Handicap_hh;
                                         $point=$point*10;
                                       ?>
                                       <?php if($point%5!=0):?>
                                          <?php 
                                            $OutPoint1=$data->oddmarket->Handicap_hh;
                                            $OutPoint2=$data->oddmarket->Handicap_hh;
                                            $OutPoint1=$OutPoint1-0.25;
                                            $OutPoint2=$OutPoint2+0.25;
                                          ?>
                                          <div align="right" id="Handicap_h{{$data->event_id}}">{{$data->oddmarket->Handicap_hp}}</div>
                                          <div align="right" id="Handicap_a{{$data->event_id}}">{{$OutPoint1}}-{{$OutPoint2}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_ap}}</div>
                                       <?php else:?>
                                          <div align="right" id="Handicap_h{{$data->event_id}}">{{$data->oddmarket->Handicap_hp}}</div>
                                          <div align="right" id="Handicap_a{{$data->event_id}}">{{$data->oddmarket->Handicap_hh}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_ap}}</div>
                                       <?php endif;?> 
                                  <?php endif;?>
                                </div>
                              </td>
                              <td>
                                <!--上半場讓球-->
                                <div id="Handicap_first{{$data->event_id}}">
                                  <?php if($data->oddmarket->Handicap_first_hh<0):?>
                                       <?php
                                         $Handicap_first_hh=abs($data->oddmarket->Handicap_first_hh);
                                         $point=$Handicap_first_hh*10;
                                       ?>
                                       <?php if($point%5!=0):?>
                                          <?php 
                                            $OutPoint1=$Handicap_first_hh;
                                            $OutPoint2=$Handicap_first_hh;
                                            $OutPoint1=$OutPoint1-0.25;
                                            $OutPoint2=$OutPoint2+0.25;
                                          ?>
                                          <div align="right" id="Handicap_first_h{{$data->event_id}}">{{$OutPoint1}}-{{$OutPoint2}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_first_hp}}</div>
                                          <div align="right" id="Handicap_first_a{{$data->event_id}}">{{$data->oddmarket->Handicap_first_ap}}</div>
                                       <?php else:?>
                                          <div align="right" id="Handicap_first_h{{$data->event_id}}">{{$Handicap_first_hh}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_first_hp}}</div>
                                          <div align="right" id="Handicap_first_a{{$data->event_id}}">{{$data->oddmarket->Handicap_first_ap}}</div>
                                       <?php endif;?>
                                  <?php elseif($data->oddmarket->Handicap_first_hh==0):?>
                                       <div align="right" id="Handicap_first_h{{$data->event_id}}">{{$data->oddmarket->Handicap_first_hh}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_first_hp}}</div>
                                       <div align="right" id="Handicap_first_a{{$data->event_id}}">{{$data->oddmarket->Handicap_first_ap}}</div>
                                  <?php else:?>
                                       <?php
                                         $point=$data->oddmarket->Handicap_first_hh;
                                         $point=$point*10;
                                       ?>
                                       <?php if($point%5!=0):?>
                                          <?php 
                                            $OutPoint1=$data->oddmarket->Handicap_first_hh;
                                            $OutPoint2=$data->oddmarket->Handicap_first_hh;
                                            $OutPoint1=$OutPoint1-0.25;
                                            $OutPoint2=$OutPoint2+0.25;
                                          ?>
                                          <div align="right" id="Handicap_first_h{{$data->event_id}}">{{$data->oddmarket->Handicap_first_hp}}</div>
                                          <div align="right" id="Handicap_first_a{{$data->event_id}}">{{$OutPoint1}}-{{$OutPoint2}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_first_ap}}</div>
                                       <?php else:?>
                                          <div align="right" id="Handicap_first_h{{$data->event_id}}">{{$data->oddmarket->Handicap_first_hp}}</div>
                                          <div align="right" id="Handicap_first_a{{$data->event_id}}">{{$data->oddmarket->Handicap_first_hh}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->Handicap_first_ap}}</div>
                                       <?php endif;?> 
                                  <?php endif;?>
                                </div>
                              </td>
                              <td>
                                <!--全場大/小-->
                                <div id="over{{$data->event_id}}">
                                       <?php
                                         $point=$data->oddmarket->over_hh;
                                         $point=$point*10;
                                       ?>
                                       <?php if($point%5!=0):?>
                                          <?php 
                                            $OutPoint1=$data->oddmarket->over_hh;
                                            $OutPoint2=$data->oddmarket->over_hh;
                                            $OutPoint1=$OutPoint1-0.25;
                                            $OutPoint2=$OutPoint2+0.25;
                                          ?>
                                          <div align="right" id="over_h{{$data->event_id}}">{{$OutPoint1}}-{{$OutPoint2}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->over_hp}}</div>
                                          <div align="right" id="over_a{{$data->event_id}}">{{$data->oddmarket->over_ap}}</div>
                                       <?php else:?>
                                          <div align="right" id="over_h{{$data->event_id}}">{{$data->oddmarket->over_hh}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->over_hp}}</div>
                                          <div align="right" id="over_a{{$data->event_id}}">{{$data->oddmarket->over_ap}}</div>
                                       <?php endif;?> 
                                </div>
                              </td>
                              <td>
                                <!--上半場大/小-->
                                <div id="over_first{{$data->event_id}}">
                                       <?php
                                         $point=$data->oddmarket->over_first_hh;
                                         $point=$point*10;
                                       ?>
                                       <?php if($point%5!=0):?>
                                          <?php 
                                            $OutPoint1=$data->oddmarket->over_first_hh;
                                            $OutPoint2=$data->oddmarket->over_first_hh;
                                            $OutPoint1=$OutPoint1-0.25;
                                            $OutPoint2=$OutPoint2+0.25;
                                          ?>
                                          <div align="right" id="over_first_h{{$data->event_id}}">{{$OutPoint1}}-{{$OutPoint2}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->over_first_hp}}</div>
                                          <div align="right" id="over_first_a{{$data->event_id}}">{{$data->oddmarket->over_first_ap}}</div>
                                       <?php else:?>
                                          <div align="right" id="over_first_h{{$data->event_id}}">{{$data->oddmarket->over_first_hh}}&nbsp;&nbsp;&nbsp;{{$data->oddmarket->over_first_hp}}</div>
                                          <div align="right" id="over_first_a{{$data->event_id}}">{{$data->oddmarket->over_first_ap}}</div>
                                       <?php endif;?> 
                                </div>
                              </td>
                              <td>
                                <!--全場標準-->
                                <div id="normal{{$data->event_id}}">
                                  <div align="right" id="normal_h{{$data->event_id}}">{{$data->oddmarket->normal_h}}</div>
                                  <div align="right" id="normal_a{{$data->event_id}}">{{$data->oddmarket->normal_a}}</div>
                                  <div align="right" id="normal_s{{$data->event_id}}">{{$data->oddmarket->normal_s}}</div>
                                </div>
                              </td>
                              <td>
                                <!--上半場標準-->
                                <div id="normal_first{{$data->event_id}}">
                                  <div align="right" id="normal_first_h{{$data->event_id}}">{{$data->oddmarket->normal_first_h}}</div>
                                  <div align="right" id="normal_first_a{{$data->event_id}}">{{$data->oddmarket->normal_first_a}}</div>
                                  <div align="right" id="normal_first_s{{$data->event_id}}">{{$data->oddmarket->normal_first_s}}</div>
                                </div>
                              </td>
                              
                            </tr>
                         @endforeach
                      </tbody>
                  </table>
              </div>

      <script>
         setInterval(function () {
                $.ajax({
                    url: "{{ url('refresh') }}",
                    success: function(res) {
                        api(res);
                        console.info('1');
                    },
                    error: function (err) {
                        console.warn(err);
                    }
                })
            }, 60000);
        function refresh()
        {
            $.ajax({
                    url: "{{ url('refresh') }}",
                    success: function(res) {
                        api(res);
                        console.info('2');
                          
                    },
                    error: function (err) {
                        console.warn(err);
                    }
                })
        }
        function api(res)
        {
          for (var i = 0; i < res.length; i++) {
                             const obj = res[i];
                             if (obj['Handicap'] !== undefined) {
                                var Handicap = obj['Handicap'];
                                var host = '';
                                var away = '';
                                if (Handicap.hh == 0) {
                                    host=obj['Handicap'].hh+"&nbsp;&nbsp;&nbsp;"+obj['Handicap'].hp;
                                    away=obj['Handicap'].ap;
                                } else if(Handicap.hh < 0) {
                                    var point=-Handicap.hh*10;
                                    var point2=-Handicap.hh;
                                    if(point%5!=0){
                                      host=(point2-0.25)+"-"+(point2+0.25)+"&nbsp;&nbsp;&nbsp;"+obj['Handicap'].hp;
                                      away=obj['Handicap'].ap;
                                    }else{
                                      host=point2+"&nbsp;&nbsp;&nbsp;"+obj['Handicap'].hp;
                                      away=obj['Handicap'].ap;
                                    }
                                }else{
                                    var point=Handicap.hh*10;
                                    var point2=Handicap.hh;
                                    if(point%5!=0){
                                      host=obj['Handicap'].hp;
                                      away=(point2-0.25)+"-"+(point2+0.25)+"&nbsp;&nbsp;&nbsp;"+obj['Handicap'].ap;
                                    }else{
                                      host=obj['Handicap'].hp;
                                      away=point2+"&nbsp;&nbsp;&nbsp;"+obj['Handicap'].ap;
                                    }
                                }
                                seeHost= host.toString();
                                seeAway= away.toString();

                                if (seeHost!=$('#Handicap_h' + obj['Handicap'].id).html()) {
                                  //console.log(seeHost, '---', $('#Handicap_h' + obj['Handicap'].id).text());
                                  $('#Handicap_h' + obj['Handicap'].id).html(host);
                                  $('#Handicap_h' + obj['Handicap'].id).css('color', 'red');
                                }
                                if (seeAway!=$('#Handicap_a' + obj['Handicap'].id).html()) {
                                  $('#Handicap_a' + obj['Handicap'].id).html(away);
                                  $('#Handicap_a' + obj['Handicap'].id).css('color', 'red');
                                }
                                    　　　
                                // after 5 second
                                setTimeout(function() {
                                  $('#Handicap_h' + obj['Handicap'].id).css('color', 'black');
                                  $('#Handicap_a' + obj['Handicap'].id).css('color', 'black');
                                }, 5000);
                             }
                             if (obj['Handicap_first'] !== undefined) {
                                var Handicap_first = obj['Handicap_first'];
                                var host = '';
                                var away = '';
                                if (Handicap_first.hh == 0) {
                                    host=obj['Handicap_first'].hh+"&nbsp;&nbsp;&nbsp;"+obj['Handicap_first'].hp;
                                    away=obj['Handicap_first'].ap;
                                } else if(Handicap_first.hh < 0) {
                                    var point=-Handicap_first.hh*10;
                                    var point2=-Handicap_first.hh;
                                    if(point%5!=0){
                                      host=(point2-0.25)+"-"+(point2+0.25)+"&nbsp;&nbsp;&nbsp;"+obj['Handicap_first'].hp;
                                      away=obj['Handicap_first'].ap;
                                    }else{
                                      host=point2+"&nbsp;&nbsp;&nbsp;"+obj['Handicap_first'].hp;
                                      away=obj['Handicap_first'].ap;
                                    }
                                }else{
                                    var point=Handicap_first.hh*10;
                                    var point2=Handicap_first.hh;
                                    if(point%5!=0){
                                      host=obj['Handicap_first'].hp;
                                      away=(point2-0.25)+"-"+(point2+0.25)+"&nbsp;&nbsp;&nbsp;"+obj['Handicap_first'].ap;
                                    }else{
                                      host=obj['Handicap_first'].hp;
                                      away=point2+"&nbsp;&nbsp;&nbsp;"+obj['Handicap_first'].ap;
                                    }
                                }
                                seeHost= host.toString();
                                seeAway= away.toString();

                                if (seeHost!=$('#Handicap_first_h' + obj['Handicap_first'].id).html()) {
                                  //console.log(seeHost, '---', $('#Handicap_first_h' + obj['Handicap_first'].id).text());
                                  $('#Handicap_first_h' + obj['Handicap_first'].id).html(host);
                                  $('#Handicap_first_h' + obj['Handicap_first'].id).css('color', 'red');
                                }
                                if (seeAway!=$('#Handicap_first_a' + obj['Handicap_first'].id).html()) {
                                  $('#Handicap_first_a' + obj['Handicap_first'].id).html(away);
                                  $('#Handicap_first_a' + obj['Handicap_first'].id).css('color', 'red');
                                }
                                
                                // after 5 second
                                setTimeout(function() {
                                  $('#Handicap_first_h' + obj['Handicap_first'].id).css('color', 'black');
                                  $('#Handicap_first_a' + obj['Handicap_first'].id).css('color', 'black');
                                }, 5000);
                             }
                             if (obj['over'] !== undefined) {
                                var over = obj['over'];
                                var host = '';
                                var away = '';
                                var point=over.hh*10;
                                var point2=over.hh;
                                if(point%5!=0){
                                  host=(point2-0.25)+"-"+(point2+0.25)+"&nbsp;&nbsp;&nbsp;"+obj['over'].hp;
                                  away=obj['over'].ap;
                                }else{
                                  host=point2+"&nbsp;&nbsp;&nbsp;"+obj['over'].hp;
                                  away=obj['over'].ap;
                                }
                                
                                seeHost= host.toString();
                                seeAway= away.toString();

                                if (seeHost!=$('#over_h' + obj['over'].id).html()) {
                                  //console.log(seeHost, '---', $('#over_h' + obj['over'].id).text());
                                  $('#over_h' + obj['over'].id).html(host);
                                  $('#over_h' + obj['over'].id).css('color', 'red');
                                }
                                if (seeAway!=$('#over_a' + obj['over'].id).html()) {
                                  $('#over_a' + obj['over'].id).html(away);
                                  $('#over_a' + obj['over'].id).css('color', 'red');
                                }
                                // after 5 second
                                setTimeout(function() {
                                  $('#over_h' + obj['over'].id).css('color', 'black');
                                  $('#over_a' + obj['over'].id).css('color', 'black');
                                }, 5000);
                             }
                             if (obj['over_first'] !== undefined) {
                                var over_first = obj['over_first'];
                                var host = '';
                                var away = '';
                                var point=over_first.hh*10;
                                var point2=over_first.hh;
                                if(point%5!=0){
                                  host=(point2-0.25)+"-"+(point2+0.25)+"&nbsp;&nbsp;&nbsp;"+obj['over_first'].hp;
                                  away=obj['over_first'].ap;
                                }else{
                                  host=point2+"&nbsp;&nbsp;&nbsp;"+obj['over_first'].hp;
                                  away=obj['over_first'].ap;
                                }
                                
                                seeHost= host.toString();
                                seeAway= away.toString();

                                if (seeHost!=$('#over_first_h' + obj['over_first'].id).html()) {
                                  //console.log(seeHost, '---', $('#over_first_h' + obj['over_first'].id).text());
                                  $('#over_first_h' + obj['over_first'].id).html(host);
                                  $('#over_first_h' + obj['over_first'].id).css('color', 'red');
                                }
                                if (seeAway!=$('#over_first_a' + obj['over_first'].id).html()) {
                                  $('#over_first_a' + obj['over_first'].id).html(away);
                                  $('#over_first_a' + obj['over_first'].id).css('color', 'red');
                                }
                                // after 5 second
                                setTimeout(function() {
                                  $('#over_first_h' + obj['over_first'].id).css('color', 'black');
                                  $('#over_first_a' + obj['over_first'].id).css('color', 'black');
                                }, 5000);
                              
                             }
                             if (obj['normal'] !== undefined) {
                                var host = '';
                                var away = '';
                                var save = '';
                                host=obj['normal'].h.toString();
                                away=obj['normal'].a.toString();
                                save=obj['normal'].s.toString();

                                if (host!=$('#normal_h' + obj['normal'].id).html()) {
                                  //console.log(seeHost, '---', $('#normal_h' + obj['over_first'].id).text());
                                  $('#normal_h' + obj['normal'].id).html(host);
                                  $('#normal_h' + obj['normal'].id).css('color', 'red');
                                }
                                if (away!=$('#normal_a' + obj['normal'].id).html()) {
                                  $('#normal_a' + obj['normal'].id).html(away);
                                  $('#normal_a' + obj['normal'].id).css('color', 'red');
                                }
                                if (save!=$('#normal_s' + obj['normal'].id).html()) {
                                  $('#normal_s' + obj['normal'].id).html(away);
                                  $('#normal_s' + obj['normal'].id).css('color', 'red');
                                }
                                // after 5 second
                                setTimeout(function() {
                                  $('#normal_h' + obj['normal'].id).css('color', 'black');
                                  $('#normal_a' + obj['normal'].id).css('color', 'black');
                                  $('#normal_s' + obj['normal'].id).css('color', 'black');
                                }, 5000);
                                
                             }
                             if (obj['normal_first'] !== undefined) {
                                var host = '';
                                var away = '';
                                var save = '';
                                host=obj['normal_first'].h.toString();
                                away=obj['normal_first'].a.toString();
                                save=obj['normal_first'].s.toString();

                                if (host!=$('#normal_first_h' + obj['normal_first'].id).html()) {
                                  //console.log(seeHost, '---', $('#normal_first_h' + obj['over_first'].id).text());
                                  $('#normal_first_h' + obj['normal_first'].id).html(host);
                                  $('#normal_first_h' + obj['normal_first'].id).css('color', 'red');
                                }
                                if (away!=$('#normal_first_a' + obj['normal_first'].id).html()) {
                                  $('#normal_first_a' + obj['normal_first'].id).html(away);
                                  $('#normal_first_a' + obj['normal_first'].id).css('color', 'red');
                                }
                                if (save!=$('#normal_first_s' + obj['normal_first'].id).html()) {
                                  $('#normal_first_s' + obj['normal_first'].id).html(away);
                                  $('#normal_first_s' + obj['normal_first'].id).css('color', 'red');
                                }
                                // after 5 second
                                setTimeout(function() {
                                  $('#normal_first_h' + obj['normal_first'].id).css('color', 'black');
                                  $('#normal_first_a' + obj['normal_first'].id).css('color', 'black');
                                  $('#normal_first_s' + obj['normal_first'].id).css('color', 'black');
                                }, 5000);
                             }
                          }
        }
      </script>
  </body>
</html>
