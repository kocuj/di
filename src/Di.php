<?php

/*
 * Di.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
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
 * @package Kocuj\Di
 */
class Di
{
    private ServiceIdDecoratorInterface $serviceIdDecorator;

    private ServiceFactoryInterface $serviceFactory;

    private ClassDefinitionFactoryInterface $classDefinitionFactory;

    private ContainerInterface $defaultContainer;

    public function __construct()
    {
        $this->serviceIdDecorator = new ServiceIdDecorator(new Camelizer());
        $serviceSourceFactory = new ServiceSourceFactory(new CoreServiceSourceClassNameServiceFactory(), new ClassDefinitionFactory(), new ClassArgumentParserFactory());
        $serviceSourceResolver = new ServiceSourceResolver($serviceSourceFactory);
        $this->serviceFactory = new ServiceFactory($serviceSourceResolver);
        $this->classDefinitionFactory = new ClassDefinitionFactory();

        $this->defaultContainer = $this->create();
    }

    public function create(): ContainerInterface
    {
        return new Container($this->serviceIdDecorator, $this->serviceFactory, $this->classDefinitionFactory);
    }

    public function copy(ContainerInterface $fromContainer): ContainerInterface
    {
        return clone $fromContainer;
    }

    public function getDefault(): ContainerInterface
    {
        return $this->defaultContainer;
    }
}
