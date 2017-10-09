<?php

/**
 * IServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Service;

use Kocuj\Di\Container\IContainer;

/**
 * Service factory interface
 */
interface IServiceFactory
{

    /**
     * Create standard or shared service
     *
     * @param IContainer $container
     *            Dependency injection container for services
     * @param ServiceType $serviceType
     *            Service type
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Source for service to create
     * @param array $arguments
     *            Service arguments to parse
     * @return IService Service creator object
     */
    public function create(IContainer $container, ServiceType $serviceType, string $id, string $source, array $arguments = []): IService;
}
