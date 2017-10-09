<?php

/**
 * ArgumentParserInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\ArgumentParser;

use Kocuj\Di\Container\ContainerInterface;

/**
 * Service argument parser
 */
interface ArgumentParserInterface
{

    /**
     * Parse service argument and return argument to service constructor
     *
     * @param ContainerInterface $container
     *            Dependency injection container for services
     * @param string $id
     *            Service identifier
     * @param array $argument
     *            Service argument to parse
     * @throws Exception
     * @return mixed Parsed argument
     */
    public function parse(ContainerInterface $container, string $id, array $argument);
}
