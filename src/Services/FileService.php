<?php

namespace App\Services;

use App\Model\BinNumberModel;
use App\Utils\Container;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FileService extends Container
{

    private $_projectDir;
    private $_path;
    private $_currency = [];


    public function __construct (ContainerInterface $defaultParameter,$path,$projectDir)
    {
        parent::__construct($defaultParameter);
        $this->_path=$path;
        $this->_projectDir = $projectDir;
    }


    public function getBinNumbersInFile(): array
    {

        $binNumbers = [];
        $inputFile = $this->_projectDir.$this->_container->getParameter('file_directory_input').$this->_path;
        $rows = file($inputFile);
        foreach ($rows as $match) {
            $match = json_decode($match,1);
            $this->_currency[] = $match['currency'];
            $bin = new BinNumberModel();
            $bin->setBin($match['bin']);
            $bin->setAmount($match['amount']);
            $bin->setCurrency($match['currency']);
            $binNumbers[] = $bin;
        }
        return $binNumbers;
    }

    /**
     * @return void
     * @throws Exception
     */
    public  function validate() {

        if(empty($this->_path)) {
            throw new Exception($this->_container->getParameter('error')['error01']);
        }
        if (!file_exists($this->_projectDir.$this->_container->getParameter('file_directory_input').$this->_path)) {
            throw new Exception($this->_container->getParameter('error')['error02']);
        }
    }

    /**
     * @param string $currency
     *
     * @return bool
     */
    public function isEu(string $currency) {
        if(in_array($currency,$this->_container->getParameter('eu')) !== false) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getCurrency (): array
    {
        return $this->_currency;
    }


}