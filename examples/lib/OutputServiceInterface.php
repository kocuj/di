<?php

/**
 * OutputServiceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Examples\Lib;

/**
 * Output service interface
 *
 * @package Kocuj\Di\Examples\Lib
 */
interface OutputServiceInterface
{
    /**
     * Display output string
     *
     * @param string $output String to display
     */
    public function displayOutput(string $output): void;
}
