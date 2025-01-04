<?php

/*
 * MultipleContainersExample.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

use Kocuj\Di\Di;
use Kocuj\Di\Examples\Lib\InputService;
use Kocuj\Di\Examples\Lib\Main;
use Kocuj\Di\Examples\Lib\OutputService;

/**
 * @package Kocuj\Di\Examples
 */

echo 'This is an example of adding services to different containers.' . PHP_EOL;
echo PHP_EOL;

require __DIR__ . '/../../../vendor/autoload.php';
$di = new Di();

$containers = [];
$containers[] = $di->getDefault();
$containers[] = $di->create();

foreach ($containers as $container) {
    $container->addStandard('input', InputService::class);
    $container->addStandard('output', OutputService::class);
    $container->addShared('mainShared', \Kocuj\Di\ClassDefinitionFactory::createWithArgumentsArray(Main::class, [
        \Kocuj\Di\ClassArgument::createForService('input'),
        \Kocuj\Di\ClassArgument::createForService('output'),
    ]));
}

foreach ($containers as $id => $container) {
    echo sprintf('CONTAINER %d:', $id + 1) . PHP_EOL;
    echo PHP_EOL;
    for ($z = 0; $z < 5; ++$z) {
        $container->get('mainShared')->display();
    }
    echo PHP_EOL;
}
