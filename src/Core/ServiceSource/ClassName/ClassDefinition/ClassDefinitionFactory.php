<?php

/*
 * ClassDefinitionFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition;

use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ClassArgumentsCollectionImmutable;

/**
 * @package Kocuj\Di
 */
class ClassDefinitionFactory implements ClassDefinitionFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(string $className, ?ClassArgumentsCollectionImmutable $classArgumentsCollectionImmutable = null): ClassDefinition {
        return new ClassDefinition($className, $classArgumentsCollectionImmutable);
    }

    public static function createWithArgumentsArray(string $className, ?array $classArguments = null): ClassDefinition
    {
        return new ClassDefinition($className, !is_null($classArguments) ? new ClassArgumentsCollectionImmutable($classArguments) : null);
    }
}
