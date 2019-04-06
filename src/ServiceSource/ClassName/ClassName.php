<?php

/**
 * ClassName.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ClassName;

use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\ServiceSource\ClassName\ArgumentParser\ArgumentParserFactoryInterface;
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
     * Service factory
     *
     * @var ServiceFactoryInterface
     */
    private $serviceFactory;

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
     * @param ServiceFactoryInterface $serviceFactory Service factory
     * @param ArgumentParserFactoryInterface $argumentParserFactory Service argument parser factory
     * @param ContainerInterface $container Dependency injection container for services
     * @param string $id Service identifier
     * @param mixed $serviceSource Service source
     * @throws Exception
     */
    public function __construct(
        ServiceFactoryInterface $serviceFactory,
        ArgumentParserFactoryInterface $argumentParserFactory,
        ContainerInterface $container,
        string $id,
        $serviceSource
    ) {
        // check if service source is a string or array
        if (!is_string($serviceSource) && !is_array($serviceSource)) {
            throw new Exception('Service source must be a string with class name or an array with class name and arguments');
        }
        // remember arguments
        $this->serviceFactory = $serviceFactory;
        $this->argumentParserFactory = $argumentParserFactory;
        $this->container = $container;
        $this->id = $id;
        $this->serviceSource = $serviceSource;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function resolve()
    {
        // parse arguments
        $parsedArgs = [];
        if (is_array($this->serviceSource) && isset($this->serviceSource['arguments'])) {
            if (!is_array($this->serviceSource['arguments'])) {
                throw new Exception('Service arguments must be an array');
            }
            foreach ($this->serviceSource['arguments'] as $argument) {
                $obj = $this->argumentParserFactory->create($this->container, $this->id, $argument);
                $parsedArgs[] = $obj->parse();
            }
        }
        // exit
        if (is_array($this->serviceSource)) {
            if (isset($this->serviceSource['className'])) {
                if (!class_exists($this->serviceSource['className'])) {
                    throw new Exception('Class does not exist');
                }
                return $this->serviceFactory->create($this->serviceSource['className'], $parsedArgs);
            } else {
                throw new Exception('No class name in service source');
            }
        } else {
            if (!class_exists($this->serviceSource)) {
                throw new Exception('Class does not exist');
            }
            return $this->serviceFactory->create($this->serviceSource, $parsedArgs);
        }
    }
}
