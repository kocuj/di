<?php

/**
 * OutputService.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Examples\Example1\Lib;

/**
 * Output service
 */
class OutputService implements IOutputService
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
     * @param string $output
     *            String to display
     * @see \Kocuj\Di\Examples\Example1\Lib\IOutputService::displayOutput()
     */
    public function displayOutput(string $output)
    {
        // display output
        echo 'Test output: ';
        echo $output;
        echo PHP_EOL;
    }
}
