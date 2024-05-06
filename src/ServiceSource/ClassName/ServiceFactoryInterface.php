<?php

/**
 * ServiceFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ClassName;

/**
 * Service factory interface
 *
 * @package Kocuj\Di\ServiceSource\ClassName
 */
interface ServiceFactoryInterface
{
    /**
     * Create service
     *
     * @param string $className Class name
     * @param array $arguments Arguments
     * @return object Created service object
     */
    public function create(string $className, array $arguments): object;
}
