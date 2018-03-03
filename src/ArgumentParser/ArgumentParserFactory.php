<?php

/**
 * ArgumentParserFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\ArgumentParser;

use Kocuj\Di\ArgumentParser\Value\Value;
use Kocuj\Di\ArgumentParser\Service\Service;
use Kocuj\Di\Container\ContainerInterface;

/**
 * Service argument parser factory
 */
class ArgumentParserFactory implements ArgumentParserFactoryInterface
{

    /**
     * Create object with parser for service argument
     *
     * @param ContainerInterface $container
     *            Dependency injection container for services
     * @param string $id
     *            Service identifier
     * @param array $argument
     *            Service argument to parse
     * @throws Exception
     * @return ArgumentParserInterface Object with service argument parser
     * @see \Kocuj\Di\ArgumentParser\ArgumentParserInterface::create() @codeCoverageIgnore
     */
    public function create(ContainerInterface $container, string $id, array $argument): ArgumentParserInterface
    {
        // exit
        switch ($argument['type']) {
            case 'service':
                return new Service($container, $id, $argument);
            case 'value':
                return new Value($argument);
            default:
                throw new Exception(sprintf('Unknown argument type "%s"', $argument['type']));
        }
    }
}
