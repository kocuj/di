<?php

/**
 * Example1.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\Examples\Example1;

use Kocuj\Di\Di;
use Kocuj\Di\Examples\Example1\Lib\InputService;
use Kocuj\Di\Examples\Example1\Lib\Main;
use Kocuj\Di\Examples\Example1\Lib\OutputService;

// autoloading
require __DIR__ . '/../../vendor/autoload.php';
// initialize DI container
$di = new Di();
// get DI container
$container = $di->getDefault();
// set DI services
$container->addShared('input', InputService::class);
$container->addShared('output', OutputService::class);
$container->addStandard('main', Main::class, [
    [
        'type' => 'service',
        'value' => 'input'
    ],
    [
        'type' => 'service',
        'value' => 'output'
    ]
]);
// execute
for ($z = 0; $z < 5; ++$z) {
    $container->/**
     * @scrutinizer ignore-call
     */
    getMain()->display();
}
for ($z = 0; $z < 5; ++$z) {
    $container->get('main')->display();
}
