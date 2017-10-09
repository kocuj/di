<?php

/**
 * ServiceType.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Service;

use Esky\Enum\Enum;

/**
 * Service type
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
