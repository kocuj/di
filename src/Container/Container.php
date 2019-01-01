<?php

/**
 * Container.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Container;

use Kocuj\Di\Service\ServiceFactoryInterface;
use Kocuj\Di\Service\ServiceType;
use Kocuj\Di\ServiceIdDecorator\ServiceIdDecoratorInterface;

/**
 * Dependency injection container for services
 *
 * @package Kocuj\Di\Container
 */
class Container implements ContainerInterface, \Countable
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
     * Services definitions
     *
     * @var array
     */
    private $definitions = [];

    /**
     * Services definitions count
     *
     * @var int
     */
    private $definitionsCount = 0;

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
     * Clear definitions
     *
     * @return void
     */
    private function clearDefinitions()
    {
        // clear definitions
        $this->definitions = [];
        $this->definitionsCount = 0;
    }

    /**
     * Add standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $id Service identifier
     * @param mixed $serviceSource Source for service to create
     * @return ContainerInterface This object
     * @throws Exception
     * @see \Kocuj\Di\Container\ContainerInterface::add()
     */
    public function add(ServiceType $serviceType, string $id, $serviceSource): ContainerInterface
    {
        // decorate service identifier
        $decoratedId = $this->serviceIdDecorator->decorate($id);
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
     * Add standard service
     *
     * @param string $id Service identifier
     * @param mixed $serviceSource Source for service to create
     * @return ContainerInterface This object
     * @throws Exception
     * @throws \Exception
     * @see \Kocuj\Di\Container\ContainerInterface::addStandard()
     * @codeCoverageIgnore
     */
    public function addStandard(string $id, $serviceSource): ContainerInterface
    {
        // exit
        return $this->add(new ServiceType(ServiceType::STANDARD), $id, $serviceSource);
    }

    /**
     * Add shared service
     *
     * @param string $id Service identifier
     * @param mixed $serviceSource Source for service to create
     * @return ContainerInterface This object
     * @throws Exception
     * @throws \Exception
     * @see \Kocuj\Di\Container\ContainerInterface::addShared()
     * @codeCoverageIgnore
     */
    public function addShared(string $id, $serviceSource): ContainerInterface
    {
        // exit
        return $this->add(new ServiceType(ServiceType::SHARED), $id, $serviceSource);
    }

    /**
     * Check service type
     *
     * @param string $id Service identifier
     * @param ServiceType $serviceType Service type
     * @return bool This service has selected type (true) or not (false)
     * @throws NotFoundException
     * @see \Kocuj\Di\Container\ContainerInterface::checkType()
     */
    public function checkType(string $id, ServiceType $serviceType): bool
    {
        // exit
        return $this->getServiceDefinition($id)['type']->getValue() === $serviceType->getValue();
    }

    /**
     * Get service definition
     *
     * @param string $id Service identifier
     * @return array Service definition
     * @throws NotFoundException
     */
    private function getServiceDefinition(string $id)
    {
        // decorate service identifier
        $decoratedId = $this->serviceIdDecorator->decorate($id);
        // check if service exists
        if (!$this->has($decoratedId)) {
            throw new NotFoundException(sprintf('Service "%s" does not exist', $decoratedId));
        }
        // exit
        return $this->definitions[$decoratedId];
    }

    /**
     * Check if service exists
     *
     * @param string $id Service
     * @return bool Service exists (true) or not (false)
     * @see \Psr\Container\ContainerInterface::has()
     */
    public function has($id): bool
    {
        // decorate service identifier
        $decoratedId = $this->serviceIdDecorator->decorate($id);
        // exit
        return isset($this->definitions[$decoratedId]);
    }

    /**
     * Get how many services are in the container
     *
     * @return int
     */
    public function count(): int
    {
        // exit
        return $this->definitionsCount;
    }

    /**
     * Call service by method get*(), where "*" is service identifier written in camel case
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
        // get service
        $service = $this->get(substr($method, 3));
        // exit
        return $service;
    }

    /**
     * Get service
     *
     * @param string $id Service identifier
     * @return object Service object
     * @throws NotFoundException
     * @see \Psr\Container\ContainerInterface::get()
     */
    public function get($id)
    {
        // exit
        return $this->getServiceDefinition($id)['service']->getService();
    }
}
