<?php

use Telegram\Bot\Api;

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$telegram = new Api($_ENV['TELEGRAM_API_TOKEN']);


$response = $telegram->getMe();

$botId = $response->getId();
$firstName = $response->getFirstName();
$username = $response->getUsername();

dd($botId, $firstName, $username);