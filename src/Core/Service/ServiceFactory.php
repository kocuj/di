<?php

/*
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\Service;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\Service\Shared\Shared;
use Kocuj\Di\Core\Service\Standard\Standard;
use Kocuj\Di\Core\ServiceSource\ServiceSourceFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ServiceSourceResolverInterface;

/**
 * @package Kocuj\Di
 */
class ServiceFactory implements ServiceFactoryInterface
{
    private ServiceSourceResolverInterface $serviceSourceResolver;

    public function __construct(ServiceSourceResolverInterface $serviceSourceResolver)
    {
        $this->serviceSourceResolver = $serviceSourceResolver;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function create(
        ContainerInterface $container,
        ServiceType $serviceType,
        string $id,
        $serviceSource
    ): ServiceInterface {
        switch ($serviceType->getValue()) {
            case ServiceType::STANDARD:
                return new Standard($this->serviceSourceResolver, $container, $id, $serviceSource);
            case ServiceType::SHARED:
                return new Shared($this->serviceSourceResolver, $container, $id, $serviceSource);
            default:
                throw new Exception(sprintf('Unknown service type "%s"', $serviceType->getValue()));
        }
    }
}
