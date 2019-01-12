<?php

/**
 * Standard.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Service\Standard;

use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\ServiceInterface;
use Kocuj\Di\ServiceSource\ServiceSourceFactoryInterface;

/**
 * Standard service creator
 *
 * @package Kocuj\Di\Service\Standard
 */
class Standard implements ServiceInterface
{
    /**
     * Service source factory
     *
     * @var ServiceSourceFactoryInterface
     */
    private $serviceSourceFactory;

    /**
     * Dependency injection container for services
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Service identifier
     *
     * @var string
     */
    private $id;

    /**
     * Source for service to create
     *
     * @var string
     */
    private $serviceSource;

    /**
     * Constructor
     *
     * @param ServiceSourceFactoryInterface $serviceSourceFactory Service source factory
     * @param ContainerInterface $container Dependency injection container for services
     * @param string $id Service identifier
     * @param mixed $serviceSource Source for service to create
     */
    public function __construct(
        ServiceSourceFactoryInterface $serviceSourceFactory,
        ContainerInterface $container,
        string $id,
        $serviceSource
    ) {
        // remember arguments
        $this->serviceSourceFactory = $serviceSourceFactory;
        $this->container = $container;
        $this->id = $id;
        $this->serviceSource = $serviceSource;
    }

    /**
     * Get service
     *
     * @return object Service object
     * @see \Kocuj\Di\Service\ServiceInterface::getService()
     */
    public function getService()
    {
        // execute service constructor
        $service = $this->serviceSourceFactory->create($this->container, $this->id, $this->serviceSource);
        // exit
        return $service->resolve();
    }
}
