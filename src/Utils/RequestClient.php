<?php

namespace App\Utils;
use GuzzleHttp\Client;

class RequestClient
{

    private $_client ;
    public function __construct ()
    {
        $this->_client = new Client();
    }

    public function sendRequest($url,$method = 'GET',$header = []) {

        try {
            $response = $this->_client->request($method,$url, ['headers' => $header]);
        }catch (\Exception $exception) {
            return  [];
        }
        return json_decode($response->getBody()->getContents(),1);

    }

}