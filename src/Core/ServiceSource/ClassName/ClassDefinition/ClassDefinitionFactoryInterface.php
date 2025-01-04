<?php

/*
 * ClassDefinitionFactoryInterface.php
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
interface ClassDefinitionFactoryInterface
{
    public function create(string $className, ?ClassArgumentsCollectionImmutable $classArgumentsCollectionImmutable = null): ClassDefinition;
}
