<?php

/**
 * ServiceSourceFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource;

use Kocuj\Di\Container\ContainerInterface;

/**
 * Service source factory interface
 *
 * @package Kocuj\Di\ServiceSource
 */
interface ServiceSourceFactoryInterface
{
    /**
     * Create service source from anonymous function, class name or object instance
     *
     * @param ContainerInterface $container Dependency injection container for services
     * @param string $id Service identifier
     * @param mixed $serviceSource Service source
     * @return ServiceSourceInterface Service source object
     */
    public function create(ContainerInterface $container, string $id, $serviceSource): ServiceSourceInterface;
}
