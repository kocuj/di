<?php

/**
 * OutputServiceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Examples\Lib;

/**
 * @package Kocuj\Di\Examples
 */
interface OutputServiceInterface
{
    public function displayOutput(string $output): void;
}
