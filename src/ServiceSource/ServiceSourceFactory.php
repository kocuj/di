<?php

/**
 * ServiceSourceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource;

use Closure;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\ServiceSource\AnonymousFunction\AnonymousFunction;
use Kocuj\Di\ServiceSource\ClassName\ArgumentParser\ArgumentParserFactory;
use Kocuj\Di\ServiceSource\ClassName\ClassName;
use Kocuj\Di\ServiceSource\ClassName\ServiceFactory;
use Kocuj\Di\ServiceSource\ObjectInstance\ObjectInstance;

/**
 * Service source factory
 *
 * @package Kocuj\Di\ServiceSource
 */
class ServiceSourceFactory implements ServiceSourceFactoryInterface
{
    /**
     * {@inheritdoc}
     * @throws Exception
     * @codeCoverageIgnore
     */
    public function create(ContainerInterface $container, string $id, $serviceSource): ServiceSourceInterface
    {
        // exit
        switch (true) {
            case is_object($serviceSource) && $serviceSource instanceof Closure:
                return new AnonymousFunction($serviceSource);
            case is_object($serviceSource) && !($serviceSource instanceof Closure):
                return new ObjectInstance($serviceSource);
            case is_array($serviceSource):
            case is_string($serviceSource):
                $serviceFactory = new ServiceFactory();
                $argumentParserFactory = new ArgumentParserFactory();
                return new ClassName($serviceFactory, $argumentParserFactory, $container, $id, $serviceSource);
            default:
                throw new Exception('Unknown service source type');
        }
    }
}
