<?php

/**
 * InputService.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Examples\Example1\Lib;

/**
 * Input service
 */
class InputService implements IInputService
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
     * @see \Kocuj\Di\Examples\Example1\Lib\IInputService::getInput()
     */
    public function getInput(): string
    {
        // exit
        return 'This is test of input in example class.';
    }
}
