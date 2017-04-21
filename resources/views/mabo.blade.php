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

              <div>
                  <table>
                      <thead>
                         <tr>
                           <th>赛事</th>
                           <th>全場標準</th>
                           <th>上半場標準</th>
                         <tr>
                      </thead>
                      <tbody>
                         <!--輸出data資料-->
                         <?php $leagueId="" ?>
                         @foreach ($datas as $key => $data) 
                            <!--輸出league_name-->
                            @if($data->oddevent->league_name!=$leagueId)
                              <tr>
                                 <td colspan="8">
                                    <span style="color:blue;font-weight:bold">{{$data->oddevent->league_name}}</span>
                                 </td>
                              </tr>
                            @endif
                            <?php $leagueId=$data->oddevent->league_name ?>
                            <!--輸出data裡的所有-->
                            <tr>
                              <td>
                                
                                  <div>{{$data->oddevent->home_name}}</div>
                                  <div>{{$data->oddevent->away_name}}</div>
                               
                              </td>
                              <!--輸出data裡的所有賠率資料-->
                              <td>
                               
                                <!--全場標準-->
                                <div id="normal{{$data->event_id}}">
                                  <div align="right" id="normal_h{{$data->event_id}}">{{$data->normal_h}}</div>
                                  <div align="right" id="normal_a{{$data->event_id}}">{{$data->normal_a}}</div>
                                  <div align="right" id="normal_s{{$data->event_id}}">{{$data->normal_s}}</div>
                                </div>
                              </td>
                              <td>
                                <!--上半場標準-->
                                <div id="normal_first{{$data->event_id}}">
                                  <div align="right" id="normal_first_h{{$data->event_id}}">{{$data->normal_first_h}}</div>
                                  <div align="right" id="normal_first_a{{$data->event_id}}">{{$data->normal_first_a}}</div>
                                  <div align="right" id="normal_first_s{{$data->event_id}}">{{$data->normal_first_s}}</div>
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
                    url: "{{ url('refresh2') }}",
                    success: function(res) {
                        api(res);
                        console.info(res);
                    },
                    error: function (err) {
                        console.warn(err);
                    }
                })
            }, 60000);
         function refresh()
        {
            $.ajax({
                    url: "{{ url('refresh2') }}",
                    success: function(res) {
                        api(res);
                        console.info(res);
                          
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
                             
                                var host = '';
                                var away = '';
                                var save = '';
                                host=obj['normal_h'][0].toString();
                                away=obj['normal_a'][0].toString();
                                save=obj['normal_s'][0].toString();

                                if (host!=$('#normal_h' + obj['event_id']).html()) {
                                  //console.log(seeHost, '---', $('#normal_h' + obj['over_first'].id).text());
                                  $('#normal_h' + obj['event_id']).html(host);
                                  $('#normal_h' + obj['event_id']).css('color', 'red');
                                }
                                if (away!=$('#normal_a' + obj['event_id']).html()) {
                                  $('#normal_a' + obj['event_id']).html(away);
                                  $('#normal_a' + obj['event_id']).css('color', 'red');
                                }
                                if (save!=$('#normal_s' + obj['event_id']).html()) {
                                  $('#normal_s' + obj['event_id']).html(away);
                                  $('#normal_s' + obj['event_id']).css('color', 'red');
                                }
                                // after 5 second
                                setTimeout(function() {
                                  $('#normal_h' + obj['event_id']).css('color', 'black');
                                  $('#normal_a' + obj['event_id']).css('color', 'black');
                                  $('#normal_s' + obj['event_id']).css('color', 'black');
                                }, 5000);

                           
                                
                                host=obj['normal_first_h'].toString();
                                away=obj['normal_first_a'].toString();
                                save=obj['normal_first_s'].toString();

                                if (host!=$('#normal_first_h' + obj['event_id']).html()) {
                                  //console.log(seeHost, '---', $('#normal_first_h' + obj['over_first'].id).text());
                                  $('#normal_first_h' + obj['event_id']).html(host);
                                  $('#normal_first_h' + obj['event_id']).css('color', 'red');
                                }
                                if (away!=$('#normal_first_a' + obj['event_id']).html()) {
                                  $('#normal_first_a' + obj['event_id']).html(away);
                                  $('#normal_first_a' + obj['event_id']).css('color', 'red');
                                }
                                if (save!=$('#normal_first_s' + obj['event_id']).html()) {
                                  $('#normal_first_s' + obj['event_id']).html(away);
                                  $('#normal_first_s' + obj['event_id']).css('color', 'red');
                                }
                                // after 5 second
                                setTimeout(function() {
                                  $('#normal_first_h' + obj['event_id']).css('color', 'black');
                                  $('#normal_first_a' + obj['event_id']).css('color', 'black');
                                  $('#normal_first_s' + obj['event_id']).css('color', 'black');
                                }, 5000);
                             
                          }
        }
      </script>
  </body>
</html>
