<?php

/**
 * CamelizerInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
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
}
