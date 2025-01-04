<?php

/*
 * ServiceSourceType.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource;

use MyCLabs\Enum\Enum;

/**
 * @package Kocuj\Di
 */
class ServiceSourceType extends Enum
{
    public const ANONYMOUS_FUNCTION = 0;

    public const CLASS_NAME = 1;

    public const OBJECT_INSTANCE = 2;
}
