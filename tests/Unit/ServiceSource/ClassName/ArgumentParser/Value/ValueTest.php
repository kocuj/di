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
 * @package Kocuj\Di\Tests
 */
class ValueTest extends TestCase
{
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
     * @param mixed $value Value
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

        $this->assertSame($parsedArg, $value);
    }

    public function parseValueProvider(): array
    {
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
