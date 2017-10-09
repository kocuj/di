<?php

/**
 * Container.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Container;

use Kocuj\Di\Service\IServiceFactory;
use Kocuj\Di\Service\ServiceFactory;
use Kocuj\Di\Service\ServiceType;
use Kocuj\Di\ServiceIdDecorator\IServiceIdDecorator;

/**
 * Dependency injection container for services
 */
class Container implements IContainer
{

    /**
     * Service identifier decorator
     *
     * @var IServiceIdDecorator
     */
    private $serviceIdDecorator;

    /**
     * Service factory
     *
     * @var IServiceFactory
     */
    private $serviceFactory;

    /**
     * Definitions
     *
     * @var array
     */
    private $definitions = [];

    /**
     * Constructor
     *
     * @param IServiceIdDecorator $serviceIdDecorator
     *            Service identifier decorator
     * @param IServiceFactory $serviceFactory
     *            Service factory
     */
    public function __construct(IServiceIdDecorator $serviceIdDecorator, IServiceFactory $serviceFactory)
    {
        // remember arguments
        $this->serviceIdDecorator = $serviceIdDecorator;
        $this->serviceFactory = $serviceFactory;
    }

    /**
     * Add standard or shared service
     *
     * @param ServiceType $serviceType
     *            Service type
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Service to create
     * @param array $arguments
     *            Service arguments to inject into constructor
     * @return IContainer This object
     * @throws ContainerException
     * @see \Kocuj\Di\Container\IContainer::add()
     */
    public function add(ServiceType $serviceType, string $id, string $source, array $arguments = []): IContainer
    {
        // decorate service identifier
        $decoratedId = $this->serviceIdDecorator->decorate($id);
        // check if service does not exist already
        if (isset($this->definitions[$decoratedId])) {
            throw new ContainerException(sprintf('Service "%s" already exists', $decoratedId));
        }
        // set service definition
        $this->definitions[$decoratedId] = [
            'service' => $this->serviceFactory->create($this, $serviceType, $decoratedId, $source, $arguments),
            'type' => $serviceType
        ];
        // exit
        return $this;
    }

    /**
     * Add standard service
     *
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Service to create
     * @param array $arguments
     *            Service arguments to inject into constructor
     * @return IContainer This object
     * @see \Kocuj\Di\Container\IContainer::addStandard() @codeCoverageIgnore
     */
    public function addStandard(string $id, string $source, array $arguments = []): IContainer
    {
        // exit
        return $this->add(new ServiceType(ServiceType::STANDARD), $id, $source, $arguments);
    }

    /**
     * Add shared service
     *
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Service to create
     * @param array $arguments
     *            Service arguments to inject into constructor
     * @return IContainer This object
     * @see \Kocuj\Di\Container\IContainer::addShared() @codeCoverageIgnore
     */
    public function addShared(string $id, string $source, array $arguments = []): IContainer
    {
        // exit
        return $this->add(new ServiceType(ServiceType::SHARED), $id, $source, $arguments);
    }

    /**
     * Get service definition
     *
     * @param string $id
     *            Service identifier
     * @return array Service definition
     * @throws NotFoundException
     */
    private function getServiceDefinition(string $id)
    {
        // decorate service identifier
        $decoratedId = $this->serviceIdDecorator->decorate($id);
        // check if service exists
        if (! $this->has($decoratedId)) {
            throw new NotFoundException(sprintf('Service "%s" does not exist', $decoratedId));
        }
        // exit
        return $this->definitions[$decoratedId];
    }

    /**
     * Get service
     *
     * @param string $id
     *            Service identifier
     * @return object Service object
     * @throws NotFoundException
     * @see \Psr\Container\ContainerInterface::get()
     */
    public function get($id)
    {
        // exit
        return $this->getServiceDefinition($id)['service']->getService();
    }

    /**
     * Get service type
     *
     * @param string $id
     *            Service identifier
     * @return ServiceType Service type
     * @throws NotFoundException
     * @see \Kocuj\Di\Container\IContainer::getType()
     */
    public function getType(string $id): ServiceType
    {
        // exit
        return $this->getServiceDefinition($id)['type'];
    }

    /**
     * Check if service exists
     *
     * @param string $id
     *            Service
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
     * Call service by method get*(), where "*" is service identifier written in camel case
     *
     * @param string $method
     *            Method to call
     * @param array $arguments
     *            Arguments for called method
     * @return object Service object
     * @throws ContainerException
     */
    public function __call(string $method, array $arguments)
    {
        // disallow any arguments
        if (! empty($arguments)) {
            throw new ContainerException('Service must be get without arguments');
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
}
