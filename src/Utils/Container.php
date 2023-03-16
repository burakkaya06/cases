<?php

namespace App\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Container
{

    protected $_container;

    public function __construct (ContainerInterface $defaultParameter)
    {
        $this->_container = $defaultParameter;
    }

}