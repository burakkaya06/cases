<?php

namespace App\Services;

use App\Model\BinNumberModel;

use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CalculateCommissionsService
{


    private $_binNumbers = [];

    private $_fileService;


    /**
     * @throws Exception
     */
    public function __construct (ContainerInterface $defaultParameter , $path , $projectDir)
    {
        $this->_container = $defaultParameter;
        $this->_fileService = new FileService($defaultParameter , $path , $projectDir);
        $this->_fileService->validate();
        $this->_binNumbers = $this->_fileService->getBinNumbersInFile();
    }


    /**
     * @return void
     * @throws Exception
     */
    public function processStart ()
    {

        $url = $this->_container->getParameter('bin_check_url');
        $binService = new BinService();
        $rateService = new ExchangeRateService();
        $rates = $rateService->getRateDetail(
            $this->_container->getParameter('exchange_rate_url') .
            '?symbols=' . implode("%2C" , $this->_fileService->getCurrency()) .
            '&base=' . $this->_container->getParameter('exchange_rate_symbol') ,

            [
                'Content-Type' => 'text/plain' ,
                'apikey' => $this->_container->getParameter('exchange_rate_api_key')
            ]);

        if ( empty($rates) ) {
            throw  new Exception($this->_container->getParameter('error')['error05']);
        }

        $rates = $rates[ 'rates' ];
        /**
         * @var $binNumber BinNumberModel
         */
        foreach ( $this->_binNumbers as $binNumber ) {
            $result = $binService->getBinDetail($url . $binNumber->getBin());

            if ( empty($result) ) {
                print_r($binNumber->getBin() . " " . $this->_container->getParameter('error')['error04'] . "\n");
                continue;
            }
            $calculatedCommission = $this->calculate($binNumber , $result[ 'country' ][ 'alpha2' ] , $rates[ $binNumber->getCurrency() ]);
            print_r($calculatedCommission . "\n");
        }
    }

    /**
     * @param BinNumberModel $binNumber
     * @param string         $currency
     * @param float          $rate
     *
     * @return float
     */
    private function calculate (BinNumberModel $binNumber , string $currency , float $rate)
    {

        if ( $currency == 'EUR' || $rate == 0 ) {
            $amntFixed = $binNumber->getAmount();
        } else {
            $amntFixed = $binNumber->getAmount() / $rate;
        }

        return round($amntFixed * ( $this->_fileService->isEu($currency) ? $this->_container->getParameter('isEu') : $this->_container->getParameter('isntEu') ) , 2);
    }

}