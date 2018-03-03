<?php

/**
 * Value.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\ArgumentParser\Value;

use Kocuj\Di\ArgumentParser\ArgumentParserInterface;
use Kocuj\Di\ArgumentParser\Exception;

/**
 * Service argument parser for value
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
     * @param array $argument
     *            Service argument to parse
     */
    public function __construct(array $argument)
    {
        // remember arguments
        $this->argument = $argument;
        // check argument
        if (! isset($this->argument['value'])) {
            throw new Exception('No "value" argument');
        }
    }

    /**
     * Parse service argument and return argument to service constructor
     *
     * @return mixed Parsed argument
     * @see \Kocuj\Di\ArgumentParser\ArgumentParserInterface::parse()
     */
    public function parse()
    {
        // exit
        return $this->argument['value'];
    }
}
