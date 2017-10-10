<?php

/**
 * Di.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di;

use Kocuj\Di\Container\Container;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\ServiceFactory;
use Kocuj\Di\Service\ServiceFactoryInterface;
use Kocuj\Di\ServiceIdDecorator\ServiceIdDecorator;
use Kocuj\Di\ServiceIdDecorator\ServiceIdDecoratorInterface;
use Kocuj\Di\Tools\Camelizer\Camelizer;

/**
 * Dependency injection containers library
 */
class Di
{

    /**
     * Service identifier decorator
     *
     * @var ServiceIdDecoratorInterface
     */
    private $serviceIdDecorator;

    /**
     * Service factory
     *
     * @var ServiceFactoryInterface
     */
    private $serviceFactory;

    /**
     * Default dependency injection container for services
     *
     * @var ContainerInterface
     */
    private $defaultContainer;

    /**
     * Constructor
     *
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        // remember arguments
        $this->serviceIdDecorator = new ServiceIdDecorator(new Camelizer());
        $this->serviceFactory = new ServiceFactory();
        // create default container
        $this->defaultContainer = $this->create();
    }

    /**
     * Create dependency injection container for services
     *
     * @return ContainerInterface @codeCoverageIgnore
     */
    public function create(): ContainerInterface
    {
        // exit
        return new Container($this->serviceIdDecorator, $this->serviceFactory);
    }

    /**
     * Get default dependency injection container for services
     *
     * @return ContainerInterface @codeCoverageIgnore
     */
    public function getDefault(): ContainerInterface
    {
        // exit
        return $this->defaultContainer;
    }
}
