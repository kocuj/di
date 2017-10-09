<?php

/**
 * FakeService.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di_tests
 */
namespace Kocuj\Di\TestsLib;

/**
 * Fake service
 */
class FakeService
{

    /**
     * Fake values
     *
     * @var array
     */
    public $values = [];

    /**
     * Constructor
     *
     * @param mixed ...$values
     *            Fake values
     */
    public function __construct(...$values)
    {
        // remember arguments
        $this->values = $values;
    }

    /**
     * Get fake value
     *
     * @param int $id
     *            Value identifier
     * @return mixed Fake value
     */
    public function getValue(int $id)
    {
        // exit
        return $this->values[$id];
    }
}
