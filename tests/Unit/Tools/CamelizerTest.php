<?php

/*
 * CamelizerTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Unit\Tools;

use Kocuj\Di\Tools\Camelizer\Camelizer;
use PHPUnit\Framework\TestCase;

/**
 * @package Kocuj\Di\Tests
 */
class CamelizerTest extends TestCase
{
    /**
     * @dataProvider camelizeProvider
     */
    public function testCamelize(string $inputText, string $expectedOutputText): void
    {
        // ---- ACT ----

        $camelizer = new Camelizer();
        $outputText = $camelizer->camelize($inputText);

        // ---- ASSERT ----

        $this->assertEquals($expectedOutputText, $outputText);
    }

    public function camelizeProvider(): array
    {
        return [
            [
                'thisService',
                'thisService'
            ],
            [
                'ThisService',
                'thisService'
            ],
            [
                'this_service',
                'thisService'
            ],
            [
                '_this_service',
                'thisService'
            ],
            [
                '-this_service',
                'thisService'
            ],
            [
                'this-service',
                'thisService'
            ],
            [
                '-this-service',
                'thisService'
            ],
            [
                '_this-service',
                'thisService'
            ],
        ];
    }

    /**
     * @dataProvider camelizeWithUpperFirstCharProvider
     */
    public function testCamelizeWithUpperFirstChar(string $inputText, string $expectedOutputText): void
    {
        // ---- ACT ----

        $camelizer = new Camelizer();
        $outputText = $camelizer->camelizeWithUpperFirstChar($inputText);

        // ---- ASSERT ----

        $this->assertEquals($expectedOutputText, $outputText);
    }

    public function camelizeWithUpperFirstCharProvider(): array
    {
        return [
            [
                'thisService',
                'ThisService'
            ],
            [
                'ThisService',
                'ThisService'
            ],
            [
                'this_service',
                'ThisService'
            ],
            [
                '_this_service',
                'ThisService'
            ],
            [
                '-this_service',
                'ThisService'
            ],
            [
                'this-service',
                'ThisService'
            ],
            [
                '-this-service',
                'ThisService'
            ],
            [
                '_this-service',
                'ThisService'
            ],
        ];
    }
}
