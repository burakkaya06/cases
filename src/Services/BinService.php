<?php

namespace App\Services;
use App\Utils\RequestClient;

class BinService
{


    /**
     * @param $url
     *
     * @return array|mixed
     */
    public function getBinDetail($url) {

        return (new RequestClient())->sendRequest($url);
    }

}