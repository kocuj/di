<?php

/*
 * ServiceSourceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource;

use Closure;
use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\ServiceSource\AnonymousFunction\AnonymousFunction;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\ClassArgumentParserFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassDefinition;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassDefinitionFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassName;
use Kocuj\Di\Core\ServiceSource\ClassName\ServiceFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ObjectInstance\ObjectInstance;

/**
 * @package Kocuj\Di
 */
class ServiceSourceFactory implements ServiceSourceFactoryInterface
{
    private ServiceFactoryInterface $serviceFactory;

    private ClassDefinitionFactoryInterface $classDefinitionFactory;

    private ClassArgumentParserFactoryInterface $classArgumentParserFactory;

    public function __construct(ServiceFactoryInterface $serviceFactory, ClassDefinitionFactoryInterface $classDefinitionFactory, ClassArgumentParserFactoryInterface $classArgumentParserFactory) {
        $this->serviceFactory = $serviceFactory;
        $this->classDefinitionFactory = $classDefinitionFactory;
        $this->classArgumentParserFactory = $classArgumentParserFactory;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function create(ServiceSourceType $serviceSourceType, ContainerInterface $container, string $id, $serviceSource): ServiceSourceInterface
    {
        switch ($serviceSourceType->getValue()) {
            case ServiceSourceType::ANONYMOUS_FUNCTION:
                return new AnonymousFunction($serviceSource);
            case ServiceSourceType::CLASS_NAME:
                return new ClassName($this->serviceFactory, $this->classDefinitionFactory, $this->classArgumentParserFactory, $container, $id, $serviceSource);
            case ServiceSourceType::OBJECT_INSTANCE:
                return new ObjectInstance($serviceSource);
            default:
                throw new Exception('Unknown service source type');
        }
    }
}
