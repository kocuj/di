<?php

/**
 * ArgumentParserFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
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
     * {@inheritdoc}
     * @throws Exception
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
