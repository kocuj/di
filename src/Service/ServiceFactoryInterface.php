<?php

/**
 * ServiceFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Service;

use Kocuj\Di\Container\ContainerInterface;

/**
 * Service factory interface
 */
interface ServiceFactoryInterface
{

    /**
     * Create standard or shared service
     *
     * @param ContainerInterface $container
     *            Dependency injection container for services
     * @param ServiceType $serviceType
     *            Service type
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Source for service to create
     * @param array $arguments
     *            Service arguments to parse
     * @return ServiceInterface Service creator object
     */
    public function create(ContainerInterface $container, ServiceType $serviceType, string $id, string $source, array $arguments = []): ServiceInterface;
}
