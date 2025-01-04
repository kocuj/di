<?php

/*
 * ServiceType.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\Service;

use MyCLabs\Enum\Enum;

/**
 * @package Kocuj\Di\Service
 */
class ServiceType extends Enum
{
    public const STANDARD = 0;

    public const SHARED = 1;
}
