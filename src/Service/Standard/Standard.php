<?php

/**
 * Standard.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
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
     */
    private ServiceSourceFactoryInterface $serviceSourceFactory;

    /**
     * Dependency injection container for services
     */
    private ContainerInterface $container;

    /**
     * Service identifier
     */
    private string $id;

    /**
     * Source for service to create
     *
     * @var mixed
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
     * {@inheritdoc}
     */
    public function getService(): object
    {
        // execute service constructor
        $service = $this->serviceSourceFactory->create($this->container, $this->id, $this->serviceSource);
        // exit
        return $service->resolve();
    }
}
