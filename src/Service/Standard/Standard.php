<?php

/**
 * Standard.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Service\Standard;

use Kocuj\Di\ArgumentParser\ArgumentParser;
use Kocuj\Di\ArgumentParser\ArgumentParserInterface;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\ServiceInterface;

/**
 * Standard service creator
 */
class Standard implements ServiceInterface
{

    /**
     * Service argument parser
     *
     * @var ArgumentParserInterface
     */
    private $argumentParser;

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
     * Source for service to create
     *
     * @var string
     */
    private $source;

    /**
     * Service arguments to parse
     *
     * @var array
     */
    private $arguments;

    /**
     * Constructor
     *
     * @param ArgumentParserInterface $argumentParser
     *            Service argument parser
     * @param ContainerInterface $container
     *            Dependency injection container for services
     * @param string $id
     *            Service identifier
     * @param string $source
     *            Source for service to create
     * @param array $arguments
     *            Service arguments to parse
     */
    public function __construct(ArgumentParserInterface $argumentParser, ContainerInterface $container, string $id, string $source, array $arguments = [])
    {
        // remember arguments
        $this->argumentParser = $argumentParser;
        $this->container = $container;
        $this->id = $id;
        $this->source = $source;
        $this->arguments = $arguments;
    }

    /**
     * Get service
     *
     * @return object Service object
     * @see \Kocuj\Di\Service\ServiceInterface::getService()
     */
    public function getService()
    {
        // parse arguments
        $parsedArgs = [];
        foreach ($this->arguments as $argument) {
            $parsedArgs[] = $this->argumentParser->parse($this->container, $this->id, $argument);
        }
        // execute service constructor
        $service = new $this->source(...$parsedArgs);
        // exit
        return $service;
    }
}
