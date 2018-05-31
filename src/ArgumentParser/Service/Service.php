<?php

/**
 * Service.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\ArgumentParser\Service;

use Kocuj\Di\ArgumentParser\ArgumentParserInterface;
use Kocuj\Di\ArgumentParser\Exception;
use Kocuj\Di\Container\ContainerInterface;

/**
 * Service argument parser for service
 *
 * @package Kocuj\Di\ArgumentParser\Service
 */
class Service implements ArgumentParserInterface
{
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
     * Service argument to parse
     *
     * @var array
     */
    private $argument;

    /**
     * Constructor
     *
     * @param ContainerInterface $container Dependency injection container for services
     * @param string $id Service identifier
     * @param array $argument Service argument to parse
     * @throws Exception
     */
    public function __construct(ContainerInterface $container, string $id, array $argument)
    {
        // remember arguments
        $this->container = $container;
        $this->id = $id;
        $this->argument = $argument;
        // check argument in "service" element - for compatibility with 1.2.0
        if (isset($this->argument['service'])) {
            $this->argument['value'] = $this->argument['service'];
            trigger_error('Argument "service" is deprecated and will be removed in version 2.0.0; please use "value" instead',
                E_USER_NOTICE);
        } else {
            // check argument
            if (!isset($this->argument['value'])) {
                throw new Exception('No "value" argument');
            }
        }
    }

    /**
     * Parse service argument and return argument to service constructor
     *
     * @throws Exception
     * @return mixed Parsed argument
     * @see \Kocuj\Di\ArgumentParser\ArgumentParserInterface::parse()
     */
    public function parse()
    {
        // get service from argument
        $service = $this->argument['value'];
        // check if service in argument is different than creating service
        if ($service === $this->id) {
            throw new Exception(sprintf('Service in argument can\'t be the same as creating service ("%s")', $service));
        }
        // exit
        return $this->container->get($service);
    }
}
