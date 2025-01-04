<?php

/**
 * OutputService.php
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
class OutputService implements OutputServiceInterface
{
    public function __construct()
    {
        echo 'OutputService created' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function displayOutput(string $output): void
    {
        echo 'Test output: ';
        echo $output;
        echo PHP_EOL;
    }
}
