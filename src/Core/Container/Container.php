<?php

/*
 * Container.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\Container;

use Countable;
use Kocuj\Di\Core\Service\ServiceFactoryInterface;
use Kocuj\Di\Core\Service\ServiceType;
use Kocuj\Di\Core\ServiceIdDecorator\ServiceIdDecoratorInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ClassArgumentsCollectionImmutable;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassDefinitionFactoryInterface;

/**
 * Dependency injection container for services
 *
 * @package Kocuj\Di\Container
 */
class Container implements ContainerInterface, Countable
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
     * Services definitions
     */
    private array $definitions = [];

    /**
     * Services definitions count
     */
    private int $definitionsCount = 0;

    public function __construct(
        ServiceIdDecoratorInterface $serviceIdDecorator,
        ServiceFactoryInterface $serviceFactory,
        ClassDefinitionFactoryInterface $classDefinitionFactory
    ) {
        $this->serviceIdDecorator = $serviceIdDecorator;
        $this->serviceFactory = $serviceFactory;
        $this->classDefinitionFactory = $classDefinitionFactory;
    }

    /**
     * Cloning container
     *
     * @return void
     * @throws Exception
     */
    public function __clone()
    {
        $oldDefinitions = $this->definitions;

        $this->clearDefinitions();
        foreach ($oldDefinitions as $definition) {
            $this->add($definition['type'], $definition['clonedata']['id'], $definition['clonedata']['serviceSource']);
        }
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function add(ServiceType $serviceType, string $id, $serviceSource, array $arguments = []): ContainerInterface
    {
        $serviceSource = $this->getDeprecatedServiceSource($serviceSource, $arguments, __METHOD__);

        $decoratedId = $this->serviceIdDecorator->decorateForServiceId($id);

        if (isset($this->definitions[$decoratedId])) {
            throw new Exception(sprintf('Service "%s" already exists', $decoratedId));
        }

        $this->definitions[$decoratedId] = [
            'service' => $this->serviceFactory->create($this, $serviceType, $decoratedId, $serviceSource),
            'type' => $serviceType,
            'clonedata' => [
                'id' => $id,
                'serviceSource' => $serviceSource,
            ]
        ];
        ++$this->definitionsCount;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     * @throws \Exception
     * @codeCoverageIgnore
     */
    public function addStandard(string $id, $serviceSource, array $arguments = []): ContainerInterface
    {
        $serviceSource = $this->getDeprecatedServiceSource($serviceSource, $arguments, __METHOD__);

        return $this->add(new ServiceType(ServiceType::STANDARD), $id, $serviceSource);
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     * @throws \Exception
     * @codeCoverageIgnore
     */
    public function addShared(string $id, $serviceSource, array $arguments = []): ContainerInterface
    {
        $serviceSource = $this->getDeprecatedServiceSource($serviceSource, $arguments, __METHOD__);

        return $this->add(new ServiceType(ServiceType::SHARED), $id, $serviceSource);
    }

    /**
     * {@inheritdoc}
     * @throws NotFoundException
     */
    public function checkType(string $id, ServiceType $serviceType): bool
    {
        return $this->getServiceDefinition($id)['type']->getValue() === $serviceType->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $id): bool
    {
        $decoratedId = $this->serviceIdDecorator->decorateForServiceId($id);

        return isset($this->definitions[$decoratedId]);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->definitionsCount;
    }

    /**
     * Call service by method get*(), where "*" is service identifier written in camel case with first upper character
     *
     * @param string $method Method to call
     * @param array $arguments Arguments for called method
     * @return object Service object
     * @throws Exception
     * @throws NotFoundException
     */
    public function __call(string $method, array $arguments)
    {
        if (!empty($arguments)) {
            throw new Exception('Service must be get without arguments');
        }

        $prefix = substr($method, 0, 3);
        if ($prefix !== 'get') {
            trigger_error(sprintf('Call to undefined method %s()', __CLASS__ . '::' . $method), E_USER_ERROR);
        }

        $serviceId = $this->serviceIdDecorator->decorateForGetMethod(substr($method, 3));

        return $this->get($serviceId);
    }

    /**
     * {@inheritdoc}
     * @throws NotFoundException
     */
    public function get(string $id)
    {
        return $this->getServiceDefinition($id)['service']->getService();
    }

    /**
     * Clear definitions
     *
     * @return void
     */
    private function clearDefinitions(): void
    {
        $this->definitions = [];
        $this->definitionsCount = 0;
    }

    /**
     * Get service definition
     *
     * @param string $id Service identifier
     * @return array Service definition
     * @throws NotFoundException
     */
    private function getServiceDefinition(string $id): array
    {
        $decoratedId = $this->serviceIdDecorator->decorateForServiceId($id);

        if (!$this->has($decoratedId)) {
            throw new NotFoundException(sprintf('Service "%s" does not exist', $decoratedId));
        }

        return $this->definitions[$decoratedId];
    }

    /**
     * Get service source converted if there was used of deprecated argument
     *
     * @param mixed $serviceSource
     * @param array $arguments
     * @param string $deprecatedMethod
     * @return mixed
     */
    private function getDeprecatedServiceSource($serviceSource, array $arguments, string $deprecatedMethod) {
        if (!empty($arguments)) {
            $serviceSource = $this->classDefinitionFactory->create($serviceSource, new ClassArgumentsCollectionImmutable($arguments));

            trigger_error('Argument $arguments for ' . $deprecatedMethod . ' method is deprecated and will be removed in version 3.0.0; please use second argument $serviceSource instead based on documentation', E_USER_DEPRECATED);
        }

        return $serviceSource;
    }
}
