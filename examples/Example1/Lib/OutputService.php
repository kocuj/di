<?php

/**
 * OutputService.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\Examples\Example1\Lib;

/**
 * Output service
 *
 * @package Kocuj\Di\Examples\Example1\Lib
 */
class OutputService implements OutputServiceInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // display information
        echo 'OutputService created' . PHP_EOL;
    }

    /**
     * Display output string
     *
     * @param string $output String to display
     * @see \Kocuj\Di\Examples\Example1\Lib\OutputServiceInterface::displayOutput()
     */
    public function displayOutput(string $output)
    {
        // display output
        echo 'Test output: ';
        echo $output;
        echo PHP_EOL;
    }
}
