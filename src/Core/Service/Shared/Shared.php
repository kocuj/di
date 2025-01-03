<?php

/*
 * Shared.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\Service\Shared;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\Service\ServiceInterface;
use Kocuj\Di\Core\ServiceSource\ServiceSourceFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ServiceSourceResolverInterface;

/**
 * Shared service creator
 *
 * @package Kocuj\Di\Service\Shared
 */
class Shared implements ServiceInterface
{
    /**
     * Service source factory
     */
    private ServiceSourceResolverInterface $serviceSourceResolver;

    /**
     * Dependency injection container for services
     */
    private ContainerInterface $container;

    /**
     * Service identifier
     */
    private string $id;

    /**
     * Source for service to create
     *
     * @var mixed
     */
    private $serviceSource;

    /**
     * Service object
     */
    private ?object $serviceObject = null;

    public function __construct(
        ServiceSourceResolverInterface $serviceSourceResolver,
        ContainerInterface $container,
        string $id,
        $serviceSource
    ) {
        // remember arguments
        $this->serviceSourceResolver = $serviceSourceResolver;
        $this->container = $container;
        $this->id = $id;
        $this->serviceSource = $serviceSource;
    }

    /**
     * {@inheritdoc}
     */
    public function getService(): object
    {
        // optionally use shared object
        if (!is_null($this->serviceObject)) {
            return $this->serviceObject;
        }
        // execute service constructor
        $this->serviceObject = $this->serviceSourceResolver->resolve($this->container, $this->id, $this->serviceSource);
        // exit
        return $this->serviceObject;
    }
}
