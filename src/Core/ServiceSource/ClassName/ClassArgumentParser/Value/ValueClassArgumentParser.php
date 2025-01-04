<?php

/*
 * ValueClassArgumentParser.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\Value;

use Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser\ClassArgumentParserInterface;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ArgumentType;
use Kocuj\Di\Core\ServiceSource\ClassName\ClassDefinition\ClassArgument\ClassArgument;
use Kocuj\Di\Core\ServiceSource\Exception;

/**
 * @package Kocuj\Di
 */
class ValueClassArgumentParser implements ClassArgumentParserInterface
{
    private ClassArgument $classArgument;

    public function __construct(ClassArgument $classArgument)
    {
        if ($classArgument->getArgumentType()->getValue() !== ArgumentType::VALUE) {
            throw new Exception(sprintf('Argument type must be set to "%d" value', ArgumentType::VALUE));
        }

        $this->classArgument = $classArgument;
    }

    /**
     * {@inheritdoc}
     */
    public function parse() {
        return $this->classArgument->getArgumentValue();
    }
}
