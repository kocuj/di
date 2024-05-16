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
     */
    public function camelize(string $text): string
    {
        $text = strtolower(substr($text, 0, 1)) . substr($text, 1);

        $text = ltrim($text, '-_');

        $text = preg_replace_callback(
            '/[-_\s]+(.)?/u',
            function ($match) {
                return isset($match[1]) ? strtoupper($match[1]) : '';
            },
            $text
        );

        return $text;
    }

    /**
     * {@inheritdoc}
     */
    public function camelizeWithUpperFirstChar(string $text): string
    {
        $output = $this->camelize($text);

        return strtoupper(substr($output, 0, 1)) . substr($output, 1);
    }
}
