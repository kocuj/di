<?php

/*
 * AnonymousFunctionExample.php
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

echo 'This is an example of adding standard service by using anonymous function.' . PHP_EOL;
echo PHP_EOL;

require __DIR__ . '/../../../vendor/autoload.php';

$di = new Di();
$container = $di->getDefault();

$container->addStandard('mainStandard', function () {
    return new Main(new InputService(), new OutputService());
});
$container->addShared('mainShared', function () {
    return new Main(new InputService(), new OutputService());
});

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
