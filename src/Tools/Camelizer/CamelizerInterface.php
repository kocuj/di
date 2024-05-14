<?php

/**
 * CamelizerInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Tools\Camelizer;

/**
 * Camelizer interface
 *
 * @package Kocuj\Di\Tools\Camelizer
 */
interface CamelizerInterface
{
    /**
     * Camelize string
     *
     * @param string $text Text to camelize
     * @return string Camelized text
     */
    public function camelize(string $text): string;

    /**
     * Camelize string with making first letter as upper
     *
     * @param string $text Text to camelize
     * @return string Camelized text with first letter as upper
     */
    public function camelizeWithUpperFirstChar(string $text): string;
}
