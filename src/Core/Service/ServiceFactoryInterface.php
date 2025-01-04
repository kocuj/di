<?php

/*
 * ServiceFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\Service;

use Kocuj\Di\Core\Container\ContainerInterface;

/**
 * @package Kocuj\Di\Service
 */
interface ServiceFactoryInterface
{
    /**
     * @param mixed $serviceSource
     */
    public function create(
        ContainerInterface $container,
        ServiceType $serviceType,
        string $id,
        $serviceSource
    ): ServiceInterface;
}
