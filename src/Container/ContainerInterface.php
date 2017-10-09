<?php

/**
 * ContainerInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Container;

use Kocuj\Di\Service\ServiceType;

/**
 * Dependency injection container interface
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{

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
     * @return ContainerInterface This object
     */
    public function add(ServiceType $serviceType, string $id, string $source, array $arguments = []): ContainerInterface;

    /**
     * Add standard service
     *
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Service to create
     * @param array $arguments
     *            Service arguments to inject into constructor
     * @return ContainerInterface This object
     */
    public function addStandard(string $id, string $source, array $arguments = []): ContainerInterface;

    /**
     * Add shared service
     *
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Service to create
     * @param array $arguments
     *            Service arguments to inject into constructor
     * @return ContainerInterface This object
     */
    public function addShared(string $id, string $source, array $arguments = []): ContainerInterface;

    /**
     * Get service type
     *
     * @param string $id
     *            Service identifier
     * @return ServiceType Service type
     * @throws NotFoundException
     */
    public function getType(string $id): ServiceType;
}
