<?php

namespace App\Model;

class BinNumberModel
{
    /**
     * @return mixed
     */
    public function getBin ()
    {
        return $this->_bin;
    }

    /**
     * @param mixed $bin
     */
    public function setBin ($bin): void
    {
        $this->_bin = $bin;
    }

    /**
     * @return mixed
     */
    public function getAmount ()
    {
        return $this->_amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount ($amount): void
    {
        $this->_amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getCurrency ()
    {
        return $this->_currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency ($currency): void
    {
        $this->_currency = $currency;
    }
    private $_bin;

    private $_amount;

    private $_currency;




}