<?php

/*
 * ServiceSourceFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource;

use Kocuj\Di\Core\Container\ContainerInterface;

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
    public function create(ServiceSourceType $serviceSourceType, ContainerInterface $container, string $id, $serviceSource): ServiceSourceInterface;
}
