<?php

/**
 * InputServiceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\Examples\Example1\Lib;

/**
 * Input service interface
 *
 * @package Kocuj\Di\Examples\Example1\Lib
 */
interface InputServiceInterface
{
    /**
     * Get input
     *
     * @return string Input string
     */
    public function getInput(): string;
}
