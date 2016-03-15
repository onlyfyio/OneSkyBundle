<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Command\PushCommand;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\TranslationServiceMock;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PushCommandTest extends \PHPUnit_Framework_TestCase
{
    use CommandTestCase;

    /**
     * @var CommandTester
     */
    private $commandTester;

    /**
     * @test
     */
    public function execute()
    {
        $this->commandTester->execute(['command' => PushCommand::COMMAND_NAME]);
        $this->assertEquals([[realpath(__DIR__.'/../../'.self::$filePaths)]], TranslationServiceMock::$pushedFilePaths);
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $command = new PushCommand();
        $command->setContainer($this->getContainer());

        $application = new Application();
        $application->add($command);

        $this->commandTester = new CommandTester($application->find($command->getName()));
    }
}
