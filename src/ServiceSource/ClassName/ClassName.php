<?php

/**
 * ClassName.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ClassName;

use Kocuj\Di\ArgumentParser\ArgumentParserFactoryInterface;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\ServiceSource\Exception;
use Kocuj\Di\ServiceSource\ServiceSourceInterface;

/**
 * Service source creator for class name
 *
 * @package Kocuj\Di\ServiceSource\ClassName
 */
class ClassName implements ServiceSourceInterface
{
    /**
     * Service argument parser factory
     *
     * @var ArgumentParserFactoryInterface
     */
    private $argumentParserFactory;

    /**
     * Dependency injection container for services
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Service identifier
     *
     * @var string
     */
    private $id;

    /**
     * Service source
     *
     * @var mixed
     */
    private $serviceSource;

    /**
     * Constructor
     *
     * @param ArgumentParserFactoryInterface $argumentParserFactory Service argument parser factory
     * @param ContainerInterface $container Dependency injection container for services
     * @param string $id Service identifier
     * @param mixed $serviceSource Service source
     * @throws Exception
     */
    public function __construct(
        ArgumentParserFactoryInterface $argumentParserFactory,
        ContainerInterface $container,
        string $id,
        $serviceSource
    ) {
        // check if service source is a string or array
        if (!is_string($serviceSource) && !is_array($serviceSource)) {
            throw new Exception('Service source is a string with class name or an array with class name and arguments');
        }
        // remember arguments
        $this->argumentParserFactory = $argumentParserFactory;
        $this->container = $container;
        $this->id = $id;
        $this->serviceSource = $serviceSource;
    }

    /**
     * Resolve a service source into an object
     *
     * @return object
     */
    public function resolve()
    {
        // parse arguments
        $parsedArgs = [];
        if (isset($this->serviceSource['arguments'])) {
            foreach ($this->serviceSource['arguments'] as $argument) {
                $obj = $this->argumentParserFactory->create($this->container, $this->id, $argument);
                $parsedArgs[] = $obj->parse();
            }
        }
        // exit
        return new ($this->serviceSource['className'])(...$parsedArgs);
    }
}
