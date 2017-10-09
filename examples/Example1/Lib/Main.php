<?php

/**
 * Main.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Examples\Example1\Lib;

/**
 * Main service
 */
class Main
{

    /**
     * Input service
     *
     * @var IInputService
     */
    private $inputService;

    /**
     * Output service
     *
     * @var IOutputService
     */
    private $outputService;

    /**
     * Constructor
     *
     * @param IInputService $inputService
     *            Input service
     * @param IOutputService $outputService
     *            Output service
     */
    public function __construct(IInputService $inputService, IOutputService $outputService)
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
