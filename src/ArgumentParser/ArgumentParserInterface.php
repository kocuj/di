<?php

/**
 * ArgumentParserInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\ArgumentParser;

/**
 * Service argument parser interface
 */
interface ArgumentParserInterface
{

    /**
     * Parse service argument and return argument to service constructor
     *
     * @return mixed Parsed argument
     */
    public function parse();
}
