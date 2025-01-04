<?php

/*
 * InputServiceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Examples\Lib;

/**
 * @package Kocuj\Di\Examples
 */
interface InputServiceInterface
{
    public function getInput(): string;
}
