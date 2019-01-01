<?php

/**
 * ServiceType.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Service;

use Esky\Enum\Enum;

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
     * @var integer
     */
    const STANDARD = 0;

    /**
     * Shared service
     *
     * @var integer
     */
    const SHARED = 1;
}
