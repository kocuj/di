<?php

/*
 * ServiceSourceResolver.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ServiceFactoryInterface;

/**
 * @package Kocuj\Di
 */
class ServiceSourceResolver implements ServiceSourceResolverInterface
{
    private ServiceSourceFactoryInterface $serviceSourceFactory;

    public function __construct(ServiceSourceFactoryInterface $serviceSourceFactory) {
        $this->serviceSourceFactory = $serviceSourceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(ContainerInterface $container, string $id, $serviceSource): object {
        foreach (ServiceSourceType::values() as $serviceSourceType) {
            $serviceSourceObject = $this->serviceSourceFactory->create($serviceSourceType, $container, $id, $serviceSource);
            if ($serviceSourceObject->supports($serviceSource)) {
                return $serviceSourceObject->resolve();
            }
        }

        throw new Exception('Service source not supported');
    }
}
