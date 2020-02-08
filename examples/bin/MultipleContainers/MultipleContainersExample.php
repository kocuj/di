<?php

/**
 * MultipleContainersExample.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

use Kocuj\Di\Di;
use Kocuj\Di\Examples\Lib\InputService;
use Kocuj\Di\Examples\Lib\Main;
use Kocuj\Di\Examples\Lib\OutputService;

// information about example
echo 'This is an example of adding services to different containers.' . PHP_EOL;
echo PHP_EOL;
// autoloading
require __DIR__ . '/../../../vendor/autoload.php';
// initialize DI container
$di = new Di();
// get DI containers
$containers = [];
$containers[] = $di->getDefault();
$containers[] = $di->create();
// set DI services
foreach ($containers as $container) {
    $container->addShared('input', [
        'className' => InputService::class,
    ]);
    $container->addShared('output', [
        'className' => OutputService::class,
    ]);
    $container->addShared('mainShared', [
        'className' => Main::class,
        'arguments' => [
            [
                'type' => 'service',
                'value' => 'input'
            ],
            [
                'type' => 'service',
                'value' => 'output'
            ],
        ],
    ]);
}
// execute
foreach ($containers as $id => $container) {
    echo sprintf('CONTAINER %d:', $id + 1) . PHP_EOL;
    echo PHP_EOL;
    for ($z = 0; $z < 5; ++$z) {
        $container->get('mainShared')->display();
    }
    echo PHP_EOL;
}
