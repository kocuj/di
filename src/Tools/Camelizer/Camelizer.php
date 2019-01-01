<?php

/**
 * Camelizer.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Tools\Camelizer;

use Stringy\Stringy;

/**
 * Camelizer
 *
 * @package Kocuj\Di\Tools\Camelizer
 */
class Camelizer implements CamelizerInterface
{
    /**
     * Camelize string
     *
     * @param string $text Text to camelize
     * @return string Camelized text
     * @see \Kocuj\Di\Tools\Camelizer\CamelizerInterface::camelize()
     * @codeCoverageIgnore
     */
    public function camelize(string $text): string
    {
        // initialize library
        $stringy = new Stringy($text);
        // exit
        return $stringy->camelize();
    }
}
