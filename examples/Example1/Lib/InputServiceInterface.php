<?php

/**
 * InputServiceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Examples\Example1\Lib;

/**
 * Input service interface
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
