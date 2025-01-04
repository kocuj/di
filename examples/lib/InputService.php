<?php

/*
 * InputService.php
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
class InputService implements InputServiceInterface
{
    public function __construct()
    {
        echo 'InputService created' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getInput(): string
    {
        return 'This is test of input in example class.';
    }
}
