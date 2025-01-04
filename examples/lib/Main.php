<?php

/*
 * Main.php
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
class Main
{
    private InputServiceInterface $inputService;

    private OutputServiceInterface $outputService;

    public function __construct(InputServiceInterface $inputService, OutputServiceInterface $outputService)
    {
        $this->inputService = $inputService;
        $this->outputService = $outputService;

        echo 'Main created' . PHP_EOL;
    }

    public function display(): void
    {
        $this->outputService->displayOutput($this->inputService->getInput());
    }
}
