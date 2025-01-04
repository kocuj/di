<?php

/*
 * Standard.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\Service\Standard;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\Service\ServiceInterface;
use Kocuj\Di\Core\ServiceSource\ServiceSourceFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ServiceSourceResolverInterface;

/**
 * @package Kocuj\Di
 */
class Standard implements ServiceInterface
{
    private ServiceSourceResolverInterface $serviceSourceResolver;

    private ContainerInterface $container;

    private string $id;

    /**
     * @var mixed
     */
    private $serviceSource;

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
        return $this->serviceSourceResolver->resolve($this->container, $this->id, $this->serviceSource);
    }
}
