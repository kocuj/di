<?php

/**
 * Container.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Container;

use Countable;
use Kocuj\Di\Service\ServiceFactoryInterface;
use Kocuj\Di\Service\ServiceType;
use Kocuj\Di\ServiceIdDecorator\ServiceIdDecoratorInterface;

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

    /**
     * Services definitions
     */
    private array $definitions = [];

    /**
     * Services definitions count
     */
    private int $definitionsCount = 0;

    /**
     * Constructor
     *
     * @param ServiceIdDecoratorInterface $serviceIdDecorator Service identifier decorator
     * @param ServiceFactoryInterface $serviceFactory Service factory
     */
    public function __construct(
        ServiceIdDecoratorInterface $serviceIdDecorator,
        ServiceFactoryInterface $serviceFactory
    ) {
        // remember arguments
        $this->serviceIdDecorator = $serviceIdDecorator;
        $this->serviceFactory = $serviceFactory;
    }

    /**
     * Cloning container
     *
     * @return void
     * @throws Exception
     */
    public function __clone()
    {
        // copy services definitions
        $oldDefinitions = $this->definitions;
        // recreate services
        $this->clearDefinitions();
        foreach ($oldDefinitions as $definition) {
            $this->add($definition['type'], $definition['clonedata']['id'], $definition['clonedata']['serviceSource']);
        }
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function add(ServiceType $serviceType, string $id, $serviceSource): ContainerInterface
    {
        // decorate service identifier
        $decoratedId = $this->serviceIdDecorator->decorateForServiceId($id);
        // check if service does not exist already
        if (isset($this->definitions[$decoratedId])) {
            throw new Exception(sprintf('Service "%s" already exists', $decoratedId));
        }
        // set service definition
        $this->definitions[$decoratedId] = [
            'service' => $this->serviceFactory->create($this, $serviceType, $decoratedId, $serviceSource),
            'type' => $serviceType,
            'clonedata' => [
                'id' => $id,
                'serviceSource' => $serviceSource,
            ]
        ];
        ++$this->definitionsCount;
        // exit
        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     * @throws \Exception
     * @codeCoverageIgnore
     */
    public function addStandard(string $id, $serviceSource): ContainerInterface
    {
        // exit
        return $this->add(new ServiceType(ServiceType::STANDARD), $id, $serviceSource);
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     * @throws \Exception
     * @codeCoverageIgnore
     */
    public function addShared(string $id, $serviceSource): ContainerInterface
    {
        // exit
        return $this->add(new ServiceType(ServiceType::SHARED), $id, $serviceSource);
    }

    /**
     * {@inheritdoc}
     * @throws NotFoundException
     */
    public function checkType(string $id, ServiceType $serviceType): bool
    {
        // exit
        return $this->getServiceDefinition($id)['type']->getValue() === $serviceType->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $id): bool
    {
        // decorate service identifier
        $decoratedId = $this->serviceIdDecorator->decorateForServiceId($id);
        // exit
        return isset($this->definitions[$decoratedId]);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        // exit
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
        // disallow any arguments
        if (!empty($arguments)) {
            throw new Exception('Service must be get without arguments');
        }
        // check prefix
        $prefix = substr($method, 0, 3);
        if ($prefix !== 'get') {
            trigger_error(sprintf('Call to undefined method %s()', __CLASS__ . '::' . $method), E_USER_ERROR);
        }
        // decorate service identifier
        $serviceId = $this->serviceIdDecorator->decorateForGetMethod(substr($method, 3));
        // exit
        return $this->get($serviceId);
    }

    /**
     * {@inheritdoc}
     * @throws NotFoundException
     */
    public function get(string $id)
    {
        // exit
        return $this->getServiceDefinition($id)['service']->getService();
    }

    /**
     * Clear definitions
     *
     * @return void
     */
    private function clearDefinitions(): void
    {
        // clear definitions
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
        // decorate service identifier
        $decoratedId = $this->serviceIdDecorator->decorateForServiceId($id);
        // check if service exists
        if (!$this->has($decoratedId)) {
            throw new NotFoundException(sprintf('Service "%s" does not exist', $decoratedId));
        }
        // exit
        return $this->definitions[$decoratedId];
    }
}
