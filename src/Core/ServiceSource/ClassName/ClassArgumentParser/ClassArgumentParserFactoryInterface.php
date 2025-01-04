<?php

/*
 * ClassArgumentParserFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ClassArgument;

/**
 * @package Kocuj\Di
 */
interface ClassArgumentParserFactoryInterface
{
    public function create(ContainerInterface $container, string $id, ClassArgument $classArgument): ClassArgumentParserInterface;
}
