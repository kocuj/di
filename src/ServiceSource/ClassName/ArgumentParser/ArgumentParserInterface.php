<?php

/**
 * ArgumentParserInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ClassName\ArgumentParser;

/**
 * Service argument parser interface
 *
 * @package Kocuj\Di\ServiceSource\ClassName\ArgumentParser
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
