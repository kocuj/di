<?php

/*
 * ArgumentType.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument;

use MyCLabs\Enum\Enum;

/**
 * @package Kocuj\Di
 */
class ArgumentType extends Enum
{
    public const SERVICE = 0;

    public const VALUE = 1;
}
