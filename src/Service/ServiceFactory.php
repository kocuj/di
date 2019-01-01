<?php

/**
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Service;

use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\Shared\Shared;
use Kocuj\Di\Service\Standard\Standard;
use Kocuj\Di\ServiceSource\ServiceSourceFactoryInterface;

/**
 * Service factory
 *
 * @package Kocuj\Di\Service
 */
class ServiceFactory implements ServiceFactoryInterface
{
    /**
     * Service source factory
     *
     * @var ServiceSourceFactoryInterface
     */
    private $serviceSourceFactory;

    /**
     * Constructor
     *
     * @param ServiceSourceFactoryInterface $serviceSourceFactory Service source factory
     * @codeCoverageIgnore
     */
    public function __construct(ServiceSourceFactoryInterface $serviceSourceFactory)
    {
        // remember arguments
        $this->serviceSourceFactory = $serviceSourceFactory;
    }

    /**
     * Create standard or shared service
     *
     * @param ContainerInterface $container Dependency injection container for services
     * @param ServiceType $serviceType Service type
     * @param string $id Service identifier
     * @param mixed $serviceSource Source for service to create
     * @return ServiceInterface Service creator object
     * @throws Exception
     * @see \Kocuj\Di\Service\ServiceFactoryInterface::create()
     * @codeCoverageIgnore
     */
    public function create(
        ContainerInterface $container,
        ServiceType $serviceType,
        string $id,
        $serviceSource
    ): ServiceInterface {
        // exit
        switch ($serviceType->getValue()) {
            case ServiceType::STANDARD:
                return new Standard($this->serviceSourceFactory, $container, $id, $serviceSource);
            case ServiceType::SHARED:
                return new Shared($this->serviceSourceFactory, $container, $id, $serviceSource);
            default:
                throw new Exception(sprintf('Unknown service type "%s"', $serviceType->getValue()));
        }
    }
}
