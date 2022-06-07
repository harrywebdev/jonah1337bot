<?php

namespace App\MessageProcess;

use Telegram\Bot\Objects\Message;

class IgnoreTextMessages
{
    const MINIMUM_TEXT_LENGTH = 40;

    /**
     * @param Message $message
     *
     * @return Message
     * @throws TextMessageIgnoredException
     */
    public static function handle(Message $message): Message
    {
        if (!$message->text) {
            return $message;
        }

        if (strlen($message->text) < self::MINIMUM_TEXT_LENGTH) {
            throw new TextMessageIgnoredException(sprintf(
                'Invalid message ID: %s. Text message shorter than %s characters.',
                $message->getMessageId(),
                self::MINIMUM_TEXT_LENGTH
            ));
        }

        return $message;
    }
}