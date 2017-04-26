<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    public function getName($leagueId)
    {
        $league = $this->find($leagueId);
        if ($league === null) {
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

            $league = \Soba::sobaGetLeagueName($leagueId);
            $this->insert([
                'id' => $leagueId,
                'name' => $league['name'],
            ]);
            return $league['name'];
        }

        return $league->name;
    }
}
