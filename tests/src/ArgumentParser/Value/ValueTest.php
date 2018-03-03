<?php

/**
 * ValueTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 * @package kocuj_di_tests
 */
namespace Kocuj\Di\Tests\ArgumentParser\Value;

use PHPUnit\Framework\TestCase;
use Kocuj\Di\ArgumentParser\Value\Value;

/**
 * Tests for Value object
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
        // arrange
        $argument = [
            'type' => 'value'
        ];
        
        // act
        $argumentParserValue = new Value($argument);
    }

    /**
     * Testing parsing value as argument
     *
     * @param mixed $value
     *            Value
     * @param mixed $expectedValue
     *            Expected value
     *            @dataProvider parseValueProvider
     */
    public function testParseValue($value, $expectedValue)
    {
        // arrange
        $argument = [
            'type' => 'value',
            'value' => $value
        ];
        
        // act
        $argumentParserValue = new Value($argument);
        $parsedArg = $argumentParserValue->parse();
        
        // assert
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
