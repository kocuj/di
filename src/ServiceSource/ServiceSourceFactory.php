<?php

/**
 * ServiceSourceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource;

use Kocuj\Di\ArgumentParser\ArgumentParserFactoryInterface;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\ServiceSource\ClassName\AnonymousFunction;
use Kocuj\Di\ServiceSource\ClassName\ClassName;
use Kocuj\Di\ServiceSource\ObjectInstance\ObjectInstance;

/**
 * Service source factory
 *
 * @package Kocuj\Di\ServiceSource
 */
class ServiceSourceFactory implements ServiceSourceFactoryInterface
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
     * @param ArgumentParserFactoryInterface $argumentParserFactory Service argument parser factory
     */
    public function __construct(ArgumentParserFactoryInterface $argumentParserFactory)
    {
        // remember arguments
        $this->argumentParserFactory = $argumentParserFactory;
    }

    /**
     * Create service source from anonymous function, class name or object instance
     *
     * @param ContainerInterface $container Dependency injection container for services
     * @param string $id Service identifier
     * @param mixed $serviceSource Service source
     * @return ServiceSourceInterface Service source object
     * @throws Exception
     * @see \Kocuj\Di\ServiceSource\ServiceSourceFactoryInterface::create()
     * @codeCoverageIgnore
     */
    public function create(ContainerInterface $container, string $id, $serviceSource): ServiceSourceInterface
    {
        // exit
        switch (true) {
            case is_object($serviceSource) && $serviceSource instanceof \Closure:
                return new AnonymousFunction($serviceSource);
            case is_object($serviceSource) && !($serviceSource instanceof \Closure):
                return new ObjectInstance($serviceSource);
            case is_array($serviceSource):
            case is_string($serviceSource):
                return new ClassName($this->argumentParserFactory, $container, $id, $serviceSource);
            default:
                throw new Exception('Unknown service source type');
        }
    }
}
