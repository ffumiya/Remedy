<?php

namespace App\Models;

use App\Logging\DefaultLogger;
use GuzzleHttp\Client;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Builder;

class Zoom
{

    const BASE_URI = 'https://api.zoom.us/v2/';

    function createJwtToken()
    {
        $api_key = config('zoom.api_key');
        $api_secret = config('zoom.api_secret');
        $signer = new Sha256();
        $key = new Key($api_secret);
        $time = time();
        $jwt_token = (new Builder())->setIssuer($api_key)
            ->expiresAt($time + 3600)
            ->sign($signer, $key)
            ->getToken();
        return $jwt_token;
    }

    function getUserId()
    {
        $method = 'GET';
        $path = 'users';
        $client_params = [
            'base_uri' => Zoom::BASE_URI,
        ];
        $result = $this->sendRequest($method, $path, $client_params);
        $user_id = $result['users'][0]['id'];
        return $user_id;
    }

    function createMeeting($start_time, $duration)
    {
        DefaultLogger::before(__METHOD__);
        $user_id = $this->getUserId();
        $params = [
            'topic' => 'オンライン診療',
            'type' => 1,
            'start_time' => $start_time,
            'duration' => $duration,
            // 'schedule_for' => 'zoomユーザーIDもしくはemailアドレス',
            'time_zone' => 'Asia/Tokyo',
            'agenda' => 'オンライン診療',
            'settings' => [
                'host_video' => true,
                'participant_video' => true,
                'join_before_host' => true,
                'approval_type' => 0,
                'audio' => 'both',
                'enforce_login' => false,
                // 'alternative_hosts' => '代替ホストメールアドレス',
                'waiting_room' => false,
                'registrants_email_notification' => false
            ]
        ];
        $method = 'POST';
        $path = 'users/' . $user_id . '/meetings';
        $client_params = [
            'base_uri' => Zoom::BASE_URI,
            'json' => $params
        ];
        DefaultLogger::debug($client_params);
        $result = $this->sendRequest($method, $path, $client_params);
        DefaultLogger::debug($result);

        DefaultLogger::after();
        return $result;
    }

    function sendRequest($method, $path, $client_params)
    {
        $client = new Client($client_params);
        $jwt_token = $this->createJwtToken();
        $response = $client->request(
            $method,
            $path,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $jwt_token,
                ]
            ]
        );
        $result_json = $response->getBody()->getContents();
        $result = json_decode($result_json, true);
        return $result;
    }
}
