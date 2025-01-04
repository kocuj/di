<?php

/*
 * ServiceSourceFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource;

use Kocuj\Di\Core\Container\ContainerInterface;

/**
 * @package Kocuj\Di\ServiceSource
 */
interface ServiceSourceFactoryInterface
{
    /**
     * @param mixed $serviceSource
     */
    public function create(ServiceSourceType $serviceSourceType, ContainerInterface $container, string $id, $serviceSource): ServiceSourceInterface;
}
