<?php

/*
 * ArgumentParserFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ClassArgument;

/**
 * Service argument parser factory interface
 *
 * @package Kocuj\Di\ServiceSource\ClassName\ArgumentParser
 */
interface ClassArgumentParserFactoryInterface
{
    public function create(ContainerInterface $container, string $id, ClassArgument $classArgument): ClassArgumentParserInterface;
}
