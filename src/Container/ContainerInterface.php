<?php

/**
 * ContainerInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Container;

use Kocuj\Di\Service\ServiceType;

/**
 * Dependency injection container interface
 *
 * @package Kocuj\Di\Container
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    /**
     * Add standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $id Service identifier
     * @param mixed $serviceSource Source for service to create
     * @return ContainerInterface This object
     */
    public function add(ServiceType $serviceType, string $id, $serviceSource): ContainerInterface;

    /**
     * Add standard service
     *
     * @param string $id Service identifier
     * @param mixed $serviceSource Source for service to create
     * @return ContainerInterface This object
     */
    public function addStandard(string $id, $serviceSource): ContainerInterface;

    /**
     * Add shared service
     *
     * @param string $id Service identifier
     * @param mixed $serviceSource Source for service to create
     * @return ContainerInterface This object
     */
    public function addShared(string $id, $serviceSource): ContainerInterface;

    /**
     * Check service type
     *
     * @param string $id Service identifier
     * @param ServiceType $serviceType Service type
     * @return bool This service has selected type (true) or not (false)
     */
    public function checkType(string $id, ServiceType $serviceType): bool;
}
