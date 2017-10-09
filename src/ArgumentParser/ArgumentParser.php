<?php

/**
 * ArgumentParser.php
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
class ArgumentParser implements ArgumentParserInterface
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
     * @see \Kocuj\Di\ArgumentParser\ArgumentParserInterface::parse()
     */
    public function parse(ContainerInterface $container, string $id, array $argument)
    {
        // parse argument
        $parsedArg = null;
        switch ($argument['type']) {
            case 'service':
                // get service from argument
                $service = $argument['service'];
                // check if service in argument is different than creating service
                if ($service === $id) {
                    throw new Exception(sprintf('Service in argument can\'t be the same as creating service (%s)', $service));
                }
                // parse argument
                $parsedArg = $container->get($service);
                break;
            case 'value':
                // parse argument
                $parsedArg = $argument['value'];
                break;
            default:
                throw new Exception(sprintf('Unknown argument type "%s"', $argument['type']));
        }
        // exit
        return $parsedArg;
    }
}
