<?php


namespace App\MessageProcess;

use Telegram\Bot\Objects\Message;

class IgnoreNotAllowedSenders
{
    /**
     * @param Message $message
     *
     * @return Message
     * @throws SenderNotAllowedException
     */
    public static function handle(Message $message): Message
    {
        if (!$message->getFrom() ||
            !in_array($message->getFrom()->getId(), explode(',', $_ENV['ALLOWED_FROM_IDS']))) {
            throw new SenderNotAllowedException(sprintf(
                    'Invalid message ID: %s. From ID: %s not allowed.',
                    $message->getMessageId(),
                    $message->getFrom() ? $message->getFrom()->getId() : 'unknown')
            );
        }

        return $message;
    }
}