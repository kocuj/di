<?php

/**
 * ObjectInstanceExample.php
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

echo 'This is an example of adding standard service by using object instance.' . PHP_EOL;
echo PHP_EOL;

require __DIR__ . '/../../../vendor/autoload.php';

$di = new Di();
$container = $di->getDefault();

$container->addShared('mainShared', new Main(new InputService(), new OutputService()));

echo PHP_EOL;
echo 'SHARED:' . PHP_EOL;
echo PHP_EOL;
for ($z = 0; $z < 5; ++$z) {
    $container->get('mainShared')->display();
}
