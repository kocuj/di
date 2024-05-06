<?php

/**
 * Di.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di;

use Kocuj\Di\Container\Container;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\ServiceFactory;
use Kocuj\Di\Service\ServiceFactoryInterface;
use Kocuj\Di\ServiceIdDecorator\ServiceIdDecorator;
use Kocuj\Di\ServiceIdDecorator\ServiceIdDecoratorInterface;
use Kocuj\Di\ServiceSource\ServiceSourceFactory;
use Kocuj\Di\Tools\Camelizer\Camelizer;

/**
 * Dependency injection containers library
 *
 * @package Kocuj\Di
 */
class Di
{
    /**
     * Service identifier decorator
     */
    private ServiceIdDecoratorInterface $serviceIdDecorator;

    /**
     * Service factory
     */
    private ServiceFactoryInterface $serviceFactory;

    /**
     * Default dependency injection container for services
     */
    private ContainerInterface $defaultContainer;

    /**
     * Constructor
     *
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        // initialize
        $this->serviceIdDecorator = new ServiceIdDecorator(new Camelizer());
        $serviceSourceFactory = new ServiceSourceFactory();
        $this->serviceFactory = new ServiceFactory($serviceSourceFactory);
        // create default container
        $this->defaultContainer = $this->create();
    }

    /**
     * Create dependency injection container for services
     *
     * @return ContainerInterface New container
     * @codeCoverageIgnore
     */
    public function create(): ContainerInterface
    {
        // exit
        return new Container($this->serviceIdDecorator, $this->serviceFactory);
    }

    /**
     * Copy container
     *
     * @param ContainerInterface $fromContainer Container from which copy will be made
     * @return ContainerInterface Copied container
     * @codeCoverageIgnore
     */
    public function copy(ContainerInterface $fromContainer): ContainerInterface
    {
        // exit
        return clone $fromContainer;
    }

    /**
     * Get default dependency injection container for services
     *
     * @return ContainerInterface Default container
     * @codeCoverageIgnore
     */
    public function getDefault(): ContainerInterface
    {
        // exit
        return $this->defaultContainer;
    }
}
