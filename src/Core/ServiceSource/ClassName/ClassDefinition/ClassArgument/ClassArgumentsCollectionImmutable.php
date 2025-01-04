<?php

/*
 * ClassArgumentsCollectionImmutable.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument;

use Kocuj\Di\Common\Collection\AbstractCollectionImmutable;

/**
 * @package Kocuj\Di
 */
class ClassArgumentsCollectionImmutable extends AbstractCollectionImmutable {
    protected ?string $requiredClass = ClassArgument::class;
}
