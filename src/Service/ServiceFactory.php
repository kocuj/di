<?php

/**
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Service;

use Kocuj\Di\ArgumentParser\ArgumentParser;
use Kocuj\Di\Container\IContainer;
use Kocuj\Di\Service\Shared\Shared;
use Kocuj\Di\Service\Standard\Standard;

/**
 * Service factory
 */
class ServiceFactory implements IServiceFactory
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
     * @see \Kocuj\Di\Service\IServiceFactory::create() @codeCoverageIgnore
     */
    public function create(IContainer $container, ServiceType $serviceType, string $id, string $source, array $arguments = []): IService
    {
        // exit
        switch ($serviceType->getValue()) {
            case ServiceType::STANDARD:
                return new Standard(new ArgumentParser(), $container, $id, $source, $arguments);
                break;
            case ServiceType::SHARED:
                return new Shared(new ArgumentParser(), $container, $id, $source, $arguments);
                break;
        }
    }
}
