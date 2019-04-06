<?php

/**
 * Value.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ClassName\ArgumentParser\Value;

use Kocuj\Di\ServiceSource\ClassName\ArgumentParser\ArgumentParserInterface;
use Kocuj\Di\ServiceSource\Exception;

/**
 * Service argument parser for value
 *
 * @package Kocuj\Di\ServiceSource\ClassName\ArgumentParser\Value
 */
class Value implements ArgumentParserInterface
{
    /**
     * Service argument to parse
     *
     * @var array
     */
    private $argument;

    /**
     * Constructor
     *
     * @param array $argument Service argument to parse
     * @throws Exception
     */
    public function __construct(array $argument)
    {
        // remember arguments
        $this->argument = $argument;
        // check argument
        if (!isset($this->argument['value'])) {
            throw new Exception('No "value" argument');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parse()
    {
        // exit
        return $this->argument['value'];
    }
}
