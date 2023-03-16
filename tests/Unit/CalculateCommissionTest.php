<?php

namespace App\Tests\Unit;

use App\Command\CalculateCommission;
use App\Services\FileService;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CalculateCommissionTest extends ServiceTestCase
{

    public function testCalculateCommission() {

        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new CalculateCommission($kernel->getProjectDir(),$kernel->getContainer()));

        $command = $application->find('app:calculate-commission');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'file' => 'input.txt'
        ));

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Calculate is Successfull',$output);
    }

}
