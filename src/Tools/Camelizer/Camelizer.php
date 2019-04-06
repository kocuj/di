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
     * {@inheritdoc}
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
