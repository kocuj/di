<?php

/*
 * ClassDefinition.php
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
class ClassDefinition
{
    private string $className;

    private ?ClassArgumentsCollectionImmutable $classArgumentsCollectionImmutable;

    public function __construct(string $className, ?ClassArgumentsCollectionImmutable $classArgumentsCollectionImmutable = null)
    {
        $this->className = $className;
        $this->classArgumentsCollectionImmutable = $classArgumentsCollectionImmutable;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getClassArgumentsCollectionImmutable(): ?ClassArgumentsCollectionImmutable
    {
        return $this->classArgumentsCollectionImmutable;
    }
}
