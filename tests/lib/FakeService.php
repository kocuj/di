<?php

/**
 * FakeService.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\TestsLib;

/**
 * Fake service
 *
 * @package Kocuj\Di\TestsLib
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
     * @param mixed ...$values Fake values
     */
    public function __construct(...$values)
    {
        // remember arguments
        $this->values = $values;
    }

    /**
     * Get fake value
     *
     * @param int $id Value identifier
     * @return mixed Fake value
     */
    public function getValue(int $id)
    {
        // exit
        return $this->values[$id];
    }
}
