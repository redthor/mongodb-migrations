<?php
declare(strict_types = 1);

namespace AntiMattr\Tests\MongoDB\Migrations\Tools\Console\Command;

use AntiMattr\MongoDB\Migrations\Tools\Console\Command\ExecuteCommand;
use AntiMattr\TestCase\AntiMattrTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * @author Ryan Catlin <ryan.catlin@gmail.com>
 */
class ExecuteCommandTest extends AntiMattrTestCase
{
    private $command;
    private $output;
    private $config;
    private $version;

    public function setUp()
    {
        $this->command = new ExecuteCommand();
        $this->output = $this->buildMock('Symfony\Component\Console\Output\OutputInterface');
        $this->config = $this->buildMock('AntiMattr\MongoDB\Migrations\Configuration\Configuration');
        $this->version = $this->buildMock('AntiMattr\MongoDB\Migrations\Version');
    }

    public function testExecuteDownWithoutInteraction()
    {
        // Variables and Objects
        $application = new Application();
        $numVersion = '11235713';
        $interactive = false;

        // Arguments and Options
        $input = new ArgvInput(
            [
                'application-name',
                ExecuteCommand::NAME,
                $numVersion,
                '--down',
            ]
        );

        // Set properties on objects
        $this->command->setApplication($application);
        $this->command->setMigrationConfiguration($this->config);
        $input->setInteractive($interactive);

        // Expectations
        $this->config->expects($this->once())
            ->method('getVersion')
            ->with($numVersion)
            ->will(
                $this->returnValue($this->version)
            )
        ;

        $this->version->expects($this->once())
            ->method('execute')
            ->with('down', false)
        ;

        // Run command, run.
        $this->command->run(
            $input,
            $this->output
        );
    }

    public function testExecuteUpWithInteraction()
    {
        // Mocks
        $question = $this->buildMock('Symfony\Component\Console\Helper\QuestionHelper');

        // Variables and Objects
        $application = new Application();
        $helperSet = new HelperSet(
            [
                'question' => $question,
            ]
        );
        $numVersion = '1234567890';
        $interactive = true;

        // Arguments and Options
        $input = new ArgvInput(
            [
                'application-name',
                ExecuteCommand::NAME,
                $numVersion,
            ]
        );

        // Set properties on objects
        $application->setHelperSet($helperSet);
        $this->command->setApplication($application);
        $this->command->setMigrationConfiguration($this->config);
        $input->setInteractive($interactive);

        // Expectations
        $this->config->expects($this->once())
            ->method('getVersion')
            ->with($numVersion)
            ->will(
                $this->returnValue($this->version)
            )
        ;

        $question->expects($this->once())
            ->method('ask')
            ->will(
                $this->returnValue(true)
            )
        ;

        $this->version->expects($this->once())
            ->method('execute')
            ->with('up', false)
        ;

        // Run command, run.
        $this->command->run(
            $input,
            $this->output
        );
    }

    public function testExecuteReplayWithoutInteraction()
    {
        // Variables and Objects
        $application = new Application();
        $numVersion = '11235713';
        $interactive = false;

        // Arguments and Options
        $input = new ArgvInput(
            [
                'application-name',
                ExecuteCommand::NAME,
                $numVersion,
                '--up',
                '--replay',
            ]
        );

        // Set properties on objects
        $this->command->setApplication($application);
        $this->command->setMigrationConfiguration($this->config);
        $input->setInteractive($interactive);

        // Expectations
        $this->config->expects($this->once())
            ->method('getVersion')
            ->with($numVersion)
            ->will(
                $this->returnValue($this->version)
            )
        ;

        $replay = true;
        $this->version->expects($this->once())
            ->method('execute')
            ->with('up', $replay)
        ;

        // Run command, run.
        $this->command->run(
            $input,
            $this->output
        );
    }
}
