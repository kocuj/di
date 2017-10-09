<?php

/**
 * OutputServiceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Examples\Example1\Lib;

/**
 * Output service interface
 */
interface OutputServiceInterface
{

    /**
     * Display output string
     *
     * @param string $output
     *            String to display
     */
    public function displayOutput(string $output);
}
