<?php

/**
 * CamelizerInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Tools\Camelizer;

/**
 * Camelizer interface
 */
interface CamelizerInterface
{

    /**
     * Camelize string
     *
     * @param string $text
     *            Text to camelize
     * @return string Camelized text
     */
    public function camelize(string $text): string;
}
