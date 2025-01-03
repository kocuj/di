<?php

/**
 * ClassNameWithArgumentsExample.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

use Kocuj\Di\Di;
use Kocuj\Di\Examples\Lib\InputService;
use Kocuj\Di\Examples\Lib\Main;
use Kocuj\Di\Examples\Lib\OutputService;

// information about example
echo 'This is an example of adding standard service by using class name with arguments also added as services.' . PHP_EOL;
echo PHP_EOL;
// autoloading
require __DIR__ . '/../../../vendor/autoload.php';
// initialize DI container
$di = new Di();
// get DI container
$container = $di->getDefault();
// set DI services
$container->addStandard('input', InputService::class);
$container->addStandard('output', OutputService::class);
$container->addStandard('mainStandard', \Kocuj\Di\ClassDefinitionFactory::createWithArgumentsArray(Main::class, [
    \Kocuj\Di\ClassArgument::createForService('input'),
    \Kocuj\Di\ClassArgument::createForService('output'),
]));
$container->addShared('mainShared', \Kocuj\Di\ClassDefinitionFactory::createWithArgumentsArray(Main::class, [
    \Kocuj\Di\ClassArgument::createForService('input'),
    \Kocuj\Di\ClassArgument::createForService('output'),
]));
// execute
echo 'STANDARD:' . PHP_EOL;
echo PHP_EOL;
for ($z = 0; $z < 5; ++$z) {
    $container->get('mainStandard')->display();
}
echo PHP_EOL;
echo 'SHARED:' . PHP_EOL;
echo PHP_EOL;
for ($z = 0; $z < 5; ++$z) {
    $container->get('mainShared')->display();
}
