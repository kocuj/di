<?php

/**
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Service;

use Kocuj\Di\ArgumentParser\ArgumentParserFactoryInterface;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\Shared\Shared;
use Kocuj\Di\Service\Standard\Standard;

/**
 * Service factory
 */
class ServiceFactory implements ServiceFactoryInterface
{

    /**
     * Service argument parser factory
     *
     * @var ArgumentParserFactoryInterface
     */
    private $argumentParserFactory;

    /**
     * Constructor
     *
     * @param
     *            ArgumentParserFactoryInterface Service argument parser factory
     *            @codeCoverageIgnore
     */
    public function __construct(ArgumentParserFactoryInterface $argumentParserFactory)
    {
        // remember arguments
        $this->argumentParserFactory = $argumentParserFactory;
    }

    /**
     * Create standard or shared service
     *
     * @param ContainerInterface $container
     *            Dependency injection container for services
     * @param ServiceType $serviceType
     *            Service type
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Source for service to create
     * @param array $arguments
     *            Service arguments to parse
     * @return ServiceInterface Service creator object
     * @see \Kocuj\Di\Service\ServiceFactoryInterface::create() @codeCoverageIgnore
     */
    public function create(ContainerInterface $container, ServiceType $serviceType, string $id, string $source, array $arguments = []): ServiceInterface
    {
        // exit
        switch ($serviceType->getValue()) {
            case ServiceType::STANDARD:
                return new Standard($this->argumentParserFactory, $container, $id, $source, $arguments);
            case ServiceType::SHARED:
                return new Shared($this->argumentParserFactory, $container, $id, $source, $arguments);
            default:
                throw new Exception(sprintf('Unknown service type "%s"', $serviceType->getValue()));
        }
    }
}
