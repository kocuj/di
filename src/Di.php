<?php

/**
 * Di.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di;

use Kocuj\Di\Core\Container\Container;
use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\Service\ServiceFactory;
use Kocuj\Di\Core\Service\ServiceFactoryInterface;
use Kocuj\Di\Core\ServiceIdDecorator\ServiceIdDecorator;
use Kocuj\Di\Core\ServiceIdDecorator\ServiceIdDecoratorInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\ClassArgumentParserFactory;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassDefinitionFactory;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassDefinitionFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ServiceFactory as CoreServiceSourceClassNameServiceFactory;
use Kocuj\Di\Core\ServiceSource\ServiceSourceFactory;
use Kocuj\Di\Common\Camelizer\Camelizer;
use Kocuj\Di\Core\ServiceSource\ServiceSourceResolver;
use Metadata\Tests\Driver\Fixture\C\SubDir\C;

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

    private ClassDefinitionFactoryInterface $classDefinitionFactory;

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
        $serviceSourceFactory = new ServiceSourceFactory(new CoreServiceSourceClassNameServiceFactory(), new ClassDefinitionFactory(), new ClassArgumentParserFactory());
        $serviceSourceResolver = new ServiceSourceResolver($serviceSourceFactory);
        $this->serviceFactory = new ServiceFactory($serviceSourceResolver);
        $this->classDefinitionFactory = new ClassDefinitionFactory();
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
        return new Container($this->serviceIdDecorator, $this->serviceFactory, $this->classDefinitionFactory);
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
