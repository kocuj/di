<?php

/**
 * ServiceSourceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource;

/**
 * Service source interface
 *
 * @package Kocuj\Di\ServiceSource
 */
interface ServiceSourceInterface
{
    /**
     * Resolve a service source into an object
     *
     * @return object
     */
    public function resolve();
}
