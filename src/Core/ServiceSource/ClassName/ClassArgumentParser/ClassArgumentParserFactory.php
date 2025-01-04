<?php

/*
 * ClassArgumentParserFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\Service\ServiceClassArgumentParser;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\Value\ValueClassArgumentParser;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ArgumentType;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ClassArgument;
use Kocuj\Di\Core\ServiceSource\Exception;

/**
 * @package Kocuj\Di
 */
class ClassArgumentParserFactory implements ClassArgumentParserFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerInterface $container, string $id, ClassArgument $classArgument): ClassArgumentParserInterface {
        switch ($classArgument->getArgumentType()->getValue()) {
            case ArgumentType::SERVICE:
                return new ServiceClassArgumentParser($container, $id, $classArgument);
            case ArgumentType::VALUE:
                return new ValueClassArgumentParser($classArgument);
            default:
                throw new Exception('Unknown class argument type');
        }
    }
}
