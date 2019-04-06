<?php

/**
 * OutputService.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Examples\Lib;

/**
 * Output service
 *
 * @package Kocuj\Di\Examples\Lib
 */
class OutputService implements OutputServiceInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // display information
        echo 'OutputService created' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function displayOutput(string $output): void
    {
        // display output
        echo 'Test output: ';
        echo $output;
        echo PHP_EOL;
    }
}
