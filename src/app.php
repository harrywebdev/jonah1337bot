<?php

use App\Command\BotCheckCommand;
use App\Command\BotGetUpdatesCommand;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$application = new Application();

$application->add(new BotCheckCommand());
$application->add(new BotGetUpdatesCommand());

$application->run();

