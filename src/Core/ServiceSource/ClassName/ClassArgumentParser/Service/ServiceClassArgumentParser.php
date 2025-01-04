<?php

/*
 * ServiceClassArgumentParser.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\Service;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\ClassArgumentParserInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ArgumentType;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ClassArgument;
use Kocuj\Di\Core\ServiceSource\Exception;

/**
 * @package Kocuj\Di\ServiceSource\ClassName\ArgumentParser
 */
class ServiceClassArgumentParser implements ClassArgumentParserInterface
{
    private ContainerInterface $container;

    private string $id;

    private ClassArgument $classArgument;

    public function __construct(ContainerInterface $container, string $id, ClassArgument $classArgument)
    {
        if ($classArgument->getArgumentType()->getValue() !== ArgumentType::SERVICE) {
            throw new Exception(sprintf('Argument type must be set to "%d" value', ArgumentType::SERVICE));
        }

        $this->container = $container;
        $this->id = $id;
        $this->classArgument = $classArgument;
    }

    /**
     * {@inheritdoc}
     */
    public function parse() {
        $serviceId = $this->classArgument->getServiceId();

        if ($serviceId === $this->id) {
            throw new Exception(sprintf('Service identifier in class argument can\'t be the same as creating service ("%s")', $serviceId));
        }

        return $this->container->get($serviceId);
    }
}
