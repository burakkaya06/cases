<?php

namespace App\Command;

use App\Services\CalculateCommissionsService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 *
 */
class CalculateCommission extends Command
{

    /**
     * @var string
     */
    protected static $defaultName = 'app:calculate-commission';

    /**
     * @var ContainerInterface
     */
    private $_defaultParameter ;

    /**
     * @param                    $projectDir
     * @param ContainerInterface $defaultParameter
     */
    public function __construct ($projectDir,ContainerInterface $defaultParameter )
    {
        $this->projectDir = $projectDir;
        $this->_defaultParameter = $defaultParameter;
        parent::__construct($projectDir);
    }


    /**
     * @return void
     */
    protected function configure ()
    {
       $this->setDescription("Calculate all commissions")
           ->addArgument('file',InputArgument::OPTIONAL,'Input File','');
    }

    /**
     * @throws Exception
     */
    protected function execute (InputInterface $input , OutputInterface $output)
    {

        try {
            $service = new CalculateCommissionsService($this->_defaultParameter,$input->getArguments()['file'],$this->projectDir);
            $service->processStart();
            $output->write("Calculate is Successfull");
        }catch (Exception $exception) {
            $output->write("Fail ".$exception->getMessage());
        }
        return 0;

    }


}