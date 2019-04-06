<?php

/**
 * ObjectInstanceExample.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

use Kocuj\Di\Di;
use Kocuj\Di\Examples\Lib\InputService;
use Kocuj\Di\Examples\Lib\Main;
use Kocuj\Di\Examples\Lib\OutputService;

// information about example
echo 'This is an example of adding standard service by using object instance.' . PHP_EOL;
echo PHP_EOL;
// autoloading
require __DIR__ . '/../../../vendor/autoload.php';
// initialize DI container
$di = new Di();
// get DI container
$container = $di->getDefault();
// set DI services
$container->addShared('mainShared', new Main(new InputService(), new OutputService()));
// execute
echo PHP_EOL;
echo 'SHARED:' . PHP_EOL;
echo PHP_EOL;
for ($z = 0; $z < 5; ++$z) {
    $container->get('mainShared')->display();
}
