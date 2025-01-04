<?php

/*
 * Class.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\ClassArgumentParserFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassDefinition;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassDefinitionFactoryInterface;
use Kocuj\Di\Core\ServiceSource\Exception;
use Kocuj\Di\Core\ServiceSource\ServiceSourceInterface;

/**
 * @package Kocuj\Di
 */
class ClassName implements ServiceSourceInterface
{
    private ServiceFactoryInterface $serviceFactory;

    private ClassDefinitionFactoryInterface $classDefinitionFactory;

    private ClassArgumentParserFactoryInterface $classArgumentParserFactory;

    private ContainerInterface $container;

    private string $id;

    /**
     * @var mixed
     */
    private $serviceSource;

    /**
     * @param mixed $serviceSource
     */
    public function __construct(
        ServiceFactoryInterface $serviceFactory,
        ClassDefinitionFactoryInterface $classDefinitionFactory,
        ClassArgumentParserFactoryInterface $classArgumentParserFactory,
        ContainerInterface $container,
        string $id,
        $serviceSource
    ) {
        $this->serviceFactory = $serviceFactory;
        $this->classDefinitionFactory = $classDefinitionFactory;
        $this->classArgumentParserFactory = $classArgumentParserFactory;
        $this->container = $container;
        $this->id = $id;
        $this->serviceSource = $serviceSource;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($serviceSource): bool {
        return is_string($serviceSource) || $serviceSource instanceof ClassDefinition;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function resolve(): object
    {
        if (!$this->supports($this->serviceSource)) {
            throw new Exception('Service source is not supported by this class');
        }

        $serviceSource = $this->serviceSource;

        if (is_string($serviceSource)) {
            $serviceSource = $this->classDefinitionFactory->create($serviceSource);
        }

        $className = $serviceSource->getClassName();
        if (!class_exists($className)) {
            throw new Exception(sprintf('Class "%s" does not exist', $className));
        }

        $parsedClassArguments = [];

        if (!is_null($serviceSource->getClassArgumentsCollectionImmutable())) {
            foreach ($serviceSource->getClassArgumentsCollectionImmutable() as $classArgument) {
                $obj = $this->classArgumentParserFactory->create($this->container, $this->id, $classArgument);
                $parsedClassArguments[] = $obj->parse();
            }
        }

        return $this->serviceFactory->create($className, $parsedClassArguments);
    }
}
