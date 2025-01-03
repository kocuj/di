<?php

/**
 * ValueTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Unit\ServiceSource\ClassName\ArgumentParser\Value;

use Kocuj\Di\Core\ServiceSource\____ClassName\ArgumentParser\Value\Value;
use Kocuj\Di\Core\ServiceSource\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Value object
 *
 * @package Kocuj\Di\Tests\ServiceSource\ClassName\ArgumentParser\Value
 */
class ValueTest extends TestCase
{
    /**
     * Testing wrong argument
     */
    public function testWrongArgument(): void
    {
        // ---- ARRANGE ----

        $argument = [
            'somewrongkey' => 'something',
        ];

        $this->expectException(Exception::class);

        // ---- ACT ----

        new Value($argument);
    }

    /**
     * Testing parsing value as argument
     *
     * @param mixed $value Value
     * @throws Exception
     * @dataProvider parseValueProvider
     */
    public function testParseValue($value): void
    {
        // ---- ARRANGE ----

        $argument = [
            'value' => $value
        ];

        // ---- ACT ----

        $argumentParserValue = new Value($argument);
        $parsedArg = $argumentParserValue->parse();

        // ---- ASSERT ----

        // check if output value is the same as input value
        $this->assertSame($parsedArg, $value);
    }

    /**
     * Provider for testing parsing value as argument
     *
     * @return array Data for testing parsing value as argument
     */
    public function parseValueProvider(): array
    {
        // exit
        return [
            [
                10,
            ],
            [
                'Test string',
            ],
            [
                12.4,
            ],
            [
                true,
            ],
            [
                new \stdClass(),
            ]
        ];
    }
}
