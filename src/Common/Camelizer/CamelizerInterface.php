<?php

/**
 * CamelizerInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Common\Camelizer;

/**
 * @package Kocuj\Di\Common\Camelizer
 */
interface CamelizerInterface
{
    public function camelize(string $text): string;

    public function camelizeWithUpperFirstChar(string $text): string;
}
