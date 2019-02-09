<?php

/**
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ClassName;

/**
 * Service factory
 *
 * @package Kocuj\Di\ServiceSource\ClassName
 */
class ServiceFactory implements ServiceFactoryInterface
{
    /**
     * Create service
     *
     * @param string $className Class name
     * @param array $arguments Arguments
     * @return object
     * @codeCoverageIgnore
     */
    public function create(string $className, array $arguments)
    {
        // exit
        return new $className(...$arguments);
    }
}
