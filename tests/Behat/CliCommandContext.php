<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use BluMS\Infrastructure\UI\Cli\Command\BluObjectMessageCommand;
use BluMS\Infrastructure\UI\Cli\Command\OrderGeneratorCommand;
use Exception;
use GreenMS\Infrastructure\UI\Cli\Command\RedObjectMessageCommand;
use LogicException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class CliCommandContext implements Context
{
    /** @var KernelInterface */
    private $kernel;
    /** @var Application */
    private $application;
    /** @var Command */
    private $command;
    /** @var CommandTester */
    private $commandTester;
    /** @var string */
    private $commandException;
    /** @var array */
    private $options;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param TableNode $tableNode
     *
     * @When /^I run the "say:hello" command with options:$/
     */
    public function iRunTheCommandWithOptions(TableNode $tableNode)
    {
        $this->setApplication();
        $this->addCommand(new HelloCommand());
        $this->setCommand('say:hello');
        $this->setOptions($tableNode);

        try {
            $this->getTester($this->command)->execute($this->options);
        } catch (Exception $exception) {
            $path = explode('\\', get_class($exception));
            $this->commandException = array_pop($path);
        }
    }

    /**
     * @Given /^I run the blu:object:message command$/
     */
    public function iRunTheBluObjectMessageCommand()
    {
        $producer = $this->kernel->getContainer()
            ->get('BluMS\Infrastructure\Integration\Outcoming\BluIntegrationEventProducer');

        $this->setApplication();
        $this->addCommand(new BluObjectMessageCommand($producer));
        $this->setCommand('blu:object:message');
        //$this->setOptions([]);

        try {
            $this->getTester($this->command)->execute([]);
        } catch (Exception $exception) {
            $path = explode('\\', get_class($exception));
            $this->commandException = array_pop($path);
        }
    }

    /**
     * @param string $expectedOutput
     *
     * @Then /^the command output should be "([^"]*)"$/
     */
    public function theCommandOutputShouldBe($expectedOutput)
    {
        $current = trim($this->commandTester->getDisplay());
        if ($current != $expectedOutput) {
            throw new LogicException(sprintf('Current output is: [%s]', $current));
        }
    }

    /**
     * @param string $expectedException
     *
     * @Then /^the command exception should be "([^"]*)"$/
     */
    public function theCommandExceptionShouldBe($expectedException)
    {
        if ($this->commandException != $expectedException) {
            throw new LogicException(sprintf('Current exception is: [%s]', $this->commandException));
        }
    }

    private function setApplication()
    {
        //$this->application = new Application($this->kernel);
        $this->application = new Application();
    }

    private function addCommand(Command $command)
    {
        $this->application->add($command);
    }

    private function setCommand($commandName)
    {
        $this->command = $this->application->find($commandName);
    }

    private function setOptions(TableNode $tableNode)
    {
        $options = [];
        foreach ($tableNode->getRowsHash() as $key => $value) {
            $options[$key] = $value;
        }

        $this->options = $options;
    }

    private function getTester(Command $command)
    {
        $this->commandTester = new CommandTester($command);

        return $this->commandTester;
    }

    /**
     * @Given /^I run the green:object:message command$/
     */
    public function iRunTheGreenObjectMessageCommand()
    {
        $producer = $this->kernel->getContainer()
            ->get('GreenMS\Infrastructure\Integration\Outcoming\GreenIntegrationEventProducer');

        $this->setApplication();
        $this->addCommand(new RedObjectMessageCommand($producer));
        $this->setCommand('green:object:message');
        //$this->setOptions([]);

        try {
            $this->getTester($this->command)->execute([]);
        } catch (Exception $exception) {
            $path = explode('\\', get_class($exception));
            $this->commandException = array_pop($path);
        }
    }

    /**
     * @Given /^I run the blums:order:generate command$/
     */
    public function iRunTheBlumsOrderGenerateCommand()
    {
        $producer = $this->kernel->getContainer()
            ->get('old_sound_rabbit_mq.order_create_producer');

        $this->setApplication();
        $this->addCommand(new OrderGeneratorCommand($producer));
        $this->setCommand('blums:order:generate');
        //$this->setOptions([]);

        try {
            $this->getTester($this->command)->execute([]);
        } catch (Exception $exception) {
            $path = explode('\\', get_class($exception));
            $this->commandException = array_pop($path);
        }
    }
}
