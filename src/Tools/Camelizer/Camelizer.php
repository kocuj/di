<?php

/**
 * Camelizer.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Tools\Camelizer;

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
        $text = strtolower(substr($text, 0, 1)) . substr($text, 1);

        $text = ltrim($text, '-_');

        $text = preg_replace_callback(
            '/[-_\s]+(.)?/u',
            function ($match) {
                if (isset($match[1])) {
                    return strtoupper($match[1]);
                }

                return '';
            },
            $text
        );

        $text = preg_replace_callback(
            '/[\d]+(.)?/u',
            function ($match) {
                return strtoupper($match[0]);
            },
            $text
        );

        return $text;
    }
}
