<?php

/**
 * InputService.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Examples\Lib;

/**
 * Input service
 *
 * @package Kocuj\Di\Examples\Lib
 */
class InputService implements InputServiceInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // display information
        echo 'InputService created' . PHP_EOL;
    }

    /**
     * Get input
     *
     * @return string Input string
     * @see \Kocuj\Di\Examples\Example1\Lib\InputServiceInterface::getInput()
     */
    public function getInput(): string
    {
        // exit
        return 'This is test of input in example class.';
    }
}
