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
 * @package Kocuj\Di
 */
class Shared implements ServiceInterface
{
    private ServiceSourceResolverInterface $serviceSourceResolver;

    private ContainerInterface $container;

    private string $id;

    /**
     * @var mixed
     */
    private $serviceSource;

    private ?object $serviceObject = null;

    public function __construct(
        ServiceSourceResolverInterface $serviceSourceResolver,
        ContainerInterface $container,
        string $id,
        $serviceSource
    ) {
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
        if (!is_null($this->serviceObject)) {
            return $this->serviceObject;
        }

        $this->serviceObject = $this->serviceSourceResolver->resolve($this->container, $this->id, $this->serviceSource);

        return $this->serviceObject;
    }
}
