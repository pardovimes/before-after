<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //FCB -> 81 (valid)
        //RM -> 86 (valid)
        //MCity -> 65 (not valid)
        $url = 'http://api.football-data.org/v2/teams/81';
        $token = '279f277c8f22437ea66dc30ad3e55c05';

        $team_info = $this->get_api_info($url, $token);
        $is_in_primeradivision = $this->check_if_is_in_competition($team_info['activeCompetitions'], 'PD');
        if(!$is_in_primeradivision) {
            return new JsonResponse(array(
                'status' => 'ko',
                'message' => 'This team is not playing \'Primera division\''
            ));
        }
        $youngest_player = $this->get_youngest_player_in_squad($team_info['squad']);
        $parsed_info_youngest_player = $this->parser_player_info($youngest_player);
        
        return new JsonResponse($parsed_info_youngest_player);
    }

    private function get_api_info($url, $api_key)
    {
        $ch = \curl_init($url);

        \curl_setopt(
            $ch, 
            CURLOPT_HTTPHEADER,
            array(
                'X-AUTH-TOKEN: '.$api_key
            )
        );
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = \curl_exec($ch);
        \curl_close($ch);

        $data = \json_decode($response, true);
        return $data;
    }

    private function check_if_is_in_competition($competitions, $competition_code)
    {
        $is_in_competition = false;
        foreach ($competitions as $competition) {
            if($competition['code'] == $competition_code){
                $is_in_competition = true;
                break;
            }
        }

        return $is_in_competition;
    }

    private function get_youngest_player_in_squad($squad)
    {
        $youngest_player = null;
        foreach ($squad as $player) {
            if($player['role']!='PLAYER') {
                continue;
            }
            if(!$youngest_player) {
                $youngest_player = $player;
            }elseif($player['dateOfBirth']>$youngest_player['dateOfBirth']){
                $youngest_player = $player;   
            }
        }
        return $youngest_player;
    }

    private function parser_player_info($player)
    {
        return array(
            "name" => $player['name'],
            "position" => $player['position'],
            "jerseyNumber" => $player['shirtNumber'],
            "dateOfBirth" => date('Y-m-d' , strtotime($player['dateOfBirth'])),
            "nationality" => $player['nationality'],
        );
    }
}
