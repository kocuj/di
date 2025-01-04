<?php

/**
 * FakeService.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Fixtures;

/**
 * @package Kocuj\Di\Tests
 */
class FakeService
{
    public array $values = [];

    /**
     * @param mixed ...$values
     */
    public function __construct(...$values)
    {
        $this->values = $values;
    }

    /**
     * @return mixed Fake value
     * @throws \Exception
     */
    public function getValue(int $id)
    {
        if (!isset($this->values[$id])) {
            throw new \Exception(sprintf('Value with identifier "%s" does not exist', $id));
        }

        return $this->values[$id];
    }
}
