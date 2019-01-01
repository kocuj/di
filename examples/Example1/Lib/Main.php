<?php

/**
 * Main.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Examples\Example1\Lib;

/**
 * Main service
 *
 * @package Kocuj\Di\Examples\Example1\Lib
 */
class Main
{
    /**
     * Input service
     *
     * @var InputServiceInterface
     */
    private $inputService;

    /**
     * Output service
     *
     * @var OutputServiceInterface
     */
    private $outputService;

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
    public function display()
    {
        // display output
        $this->outputService->displayOutput($this->inputService->getInput());
    }
}
