<?php


namespace App\Command;

use Telegram\Bot\Api;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'bot:check')]
class BotCheckCommand extends Command
{
    protected static $defaultName = 'bot:check';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $telegram = new Api($_ENV['TELEGRAM_API_TOKEN']);

        $response = $telegram->getMe();

        $botId     = $response->getId();
        $firstName = $response->getFirstName();
        $username  = $response->getUsername();

        $output->writeln("=======================");
        $output->writeln("Check successful. Info:");
        $output->writeln("=======================");
        $output->writeln("Bot Id: $botId");
        $output->writeln("First Name: $firstName");
        $output->writeln("Username: $username");
        $output->writeln("=======================");

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}