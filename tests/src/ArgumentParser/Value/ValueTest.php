<?php

/**
 * ValueTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Tests\ArgumentParser\Value;

use Kocuj\Di\ArgumentParser\Exception;
use Kocuj\Di\ArgumentParser\Value\Value;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Value object
 *
 * @package Kocuj\Di\Tests\ArgumentParser\Value
 */
class ValueTest extends TestCase
{
    /**
     * Testing wrong argument
     *
     * @expectedException \Kocuj\Di\ArgumentParser\Exception
     */
    public function testWrongArgument()
    {
        // ---- ARRANGE ----

        $argument = [
            'type' => 'value'
        ];

        // ---- ACT ----

        $argumentParserValue = new Value($argument);
    }

    /**
     * Testing parsing value as argument
     *
     * @param mixed $value Value
     * @param mixed $expectedValue Expected value
     * @throws Exception
     * @dataProvider parseValueProvider
     */
    public function testParseValue($value, $expectedValue)
    {
        // ---- ARRANGE ----

        $argument = [
            'type' => 'value',
            'value' => $value
        ];

        // ---- ACT ----

        $argumentParserValue = new Value($argument);
        $parsedArg = $argumentParserValue->parse();

        // ---- ASSERT ----

        $this->assertSame($parsedArg, $value);
    }

    /**
     * Provider for testing parsing value as argument
     *
     * @return array Data for testing parsing value as argument
     */
    public function parseValueProvider(): array
    {
        // initialize standard object
        $obj = new \stdClass();
        // exit
        return [
            [
                10,
                10
            ],
            [
                'Test string',
                'Test string'
            ],
            [
                12.4,
                12.4
            ],
            [
                true,
                true
            ],
            [
                $obj,
                $obj
            ]
        ];
    }
}
