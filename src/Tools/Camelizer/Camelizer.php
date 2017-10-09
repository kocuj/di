<?php

/**
 * Camelizer.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Tools\Camelizer;

use Stringy\Stringy;

/**
 * Camelizer
 */
class Camelizer implements ICamelizer
{

    /**
     * Camelize string
     *
     * @param string $text
     *            Text to camelize
     * @return string Camelized text
     * @see \Kocuj\Di\Tools\Camelizer\ICamelizer::camelize() @codeCoverageIgnore
     */
    public function camelize(string $text): string
    {
        // initialize library
        $stringy = new Stringy($text);
        // exit
        return $stringy->camelize();
    }
}
