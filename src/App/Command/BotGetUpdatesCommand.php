<?php


namespace App\Command;

use App\MessageProcess\IgnoreNotAllowedSenders;
use App\MessageProcess\IgnoreTextMessages;
use Telegram\Bot\Api;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'bot:updates')]
class BotGetUpdatesCommand extends Command
{
    protected static $defaultName = 'bot:updates';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $telegram = new Api($_ENV['TELEGRAM_API_TOKEN']);
//        $telegram->setAsyncRequest(true);

        $updates = $telegram->getUpdates([
            'offset'  => 0,
            'limit'   => 10,
            'timeout' => 5,
        ]);

        $skippedUpdates = [];

        /** @var Update $update */
        foreach ($updates as $update) {
            /** @var Message $message */
            $message = $update->getMessage();

            try {
                IgnoreNotAllowedSenders::handle($message);
                IgnoreTextMessages::handle($message);
            } catch (\Exception $e) {
                $output->writeln('<error>' . $e->getMessage() . '</error>');
                $skippedUpdates [] = $update;
                continue;
            }

            // we care about text that is longer than 50 chars (so assuming some kind
            // of better insight/message

            // now process the message
            $output->writeln('Processing msg: ' . $message->getMessageId());
        }

//        dd($updates);

//        dd($skippedUpdates);

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