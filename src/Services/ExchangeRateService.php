<?php

namespace App\Services;

use App\Utils\RequestClient;

class ExchangeRateService
{

    /**
     * @param string $url
     * @param array  $header
     *
     * @return array|mixed
     */
    public function getRateDetail(string $url,array $header) {

        return (new RequestClient())->sendRequest($url,'GET',$header);
    }

}