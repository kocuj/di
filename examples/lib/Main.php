<?php

/**
 * Main.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Examples\Lib;

/**
 * Main service
 *
 * @package Kocuj\Di\Examples\Lib
 */
class Main
{
    /**
     * Input service
     */
    private InputServiceInterface $inputService;

    /**
     * Output service
     */
    private OutputServiceInterface $outputService;

    /**
     * Constructor
     *
     * @param InputServiceInterface $inputService Input service
     * @param OutputServiceInterface $outputService Output service
     */
    public function __construct(InputServiceInterface $inputService, OutputServiceInterface $outputService)
    {
        // remember arguments
        $this->inputService = $inputService;
        $this->outputService = $outputService;
        // display information
        echo 'Main created' . PHP_EOL;
    }

    /**
     * Display
     */
    public function display(): void
    {
        // display output
        $this->outputService->displayOutput($this->inputService->getInput());
    }
}
