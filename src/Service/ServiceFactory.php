<?php

/**
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
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
     */
    private ServiceSourceFactoryInterface $serviceSourceFactory;

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
     * {@inheritdoc}
     * @throws Exception
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
