<?php

/**
 * ArgumentParserFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ClassName\ArgumentParser;

use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\ServiceSource\ClassName\ArgumentParser\Service\Service;
use Kocuj\Di\ServiceSource\ClassName\ArgumentParser\Value\Value;
use Kocuj\Di\ServiceSource\Exception;

/**
 * Service argument parser factory
 *
 * @package Kocuj\Di\ServiceSource\ClassName\ArgumentParser
 */
class ArgumentParserFactory implements ArgumentParserFactoryInterface
{
    /**
     * Create object with parser for service argument
     *
     * @param ContainerInterface $container Dependency injection container for services
     * @param string $id Service identifier
     * @param array $argument Service argument to parse
     * @throws Exception
     * @return ArgumentParserInterface Object with service argument parser
     * @see \Kocuj\Di\ServiceSource\ClassName\ArgumentParser\ArgumentParserInterface::create()
     * @codeCoverageIgnore
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
