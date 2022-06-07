<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$telegram = new \Telegram\Bot\Api($_ENV['TELEGRAM_API_TOKEN']);