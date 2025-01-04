<?php

/*
 * ContainerInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\Container;

use Kocuj\Di\Core\Service\ServiceType;

/**
 * @package Kocuj\Di
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    /**
     * @param mixed $serviceSource
     */
    public function add(ServiceType $serviceType, string $id, $serviceSource): ContainerInterface;

    /**
     * @param mixed $serviceSource
     */
    public function addStandard(string $id, $serviceSource): ContainerInterface;

    /**
     * @param mixed $serviceSource
     */
    public function addShared(string $id, $serviceSource): ContainerInterface;

    public function checkType(string $id, ServiceType $serviceType): bool;
}
