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
 * Service type
 *
 * @package Kocuj\Di\Service
 */
class ServiceType extends Enum
{
    /**
     * Standard service
     *
     * @var int
     */
    public const STANDARD = 0;

    /**
     * Shared service
     *
     * @var int
     */
    public const SHARED = 1;
}
