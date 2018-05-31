<?php

/**
 * ArgumentParserFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\ArgumentParser;

use Kocuj\Di\Container\ContainerInterface;

/**
 * Service argument parser factory interface
 *
 * @package Kocuj\Di\ArgumentParser
 */
interface ArgumentParserFactoryInterface
{
    /**
     * Create object with parser for service argument
     *
     * @param ContainerInterface $container Dependency injection container for services
     * @param string $id Service identifier
     * @param array $argument Service argument to parse
     * @return ArgumentParserInterface Object with service argument parser
     */
    public function create(ContainerInterface $container, string $id, array $argument): ArgumentParserInterface;
}
