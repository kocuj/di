<?php

/*
 * CamelizerTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

namespace Kocuj\Di\Tests\Unit\Tools;

use Kocuj\Di\Tools\Camelizer\Camelizer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Camelizer object
 *
 * @package Kocuj\Di\Tests\Tools
 */
class CamelizerTest extends TestCase
{
    /**
     * Testing camelize of strings
     *
     * @dataProvider camelizeProvider
     */
    public function testCamelize(string $inputText, string $expectedOutputText): void
    {
        // ---- ACT ----

        // initialize Camelizer
        $camelizer = new Camelizer();
        // camelize text
        $outputText = $camelizer->camelize($inputText);

        // ---- ASSERT ----

        // check if output text is the same as expected
        $this->assertEquals($expectedOutputText, $outputText);
    }

    /**
     * Provider for testing camelize of strings
     */
    public function camelizeProvider(): array
    {
        // exit
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
     * Testing camelize (with first character uppercase) of strings
     *
     * @dataProvider camelizeWithUpperFirstCharProvider
     */
    public function testCamelizeWithUpperFirstChar(string $inputText, string $expectedOutputText): void
    {
        // ---- ACT ----

        // initialize Camelizer
        $camelizer = new Camelizer();
        // camelize text
        $outputText = $camelizer->camelizeWithUpperFirstChar($inputText);

        // ---- ASSERT ----

        // check if output text is the same as expected
        $this->assertEquals($expectedOutputText, $outputText);
    }

    /**
     * Provider for testing camelize (with first character uppercase) of strings
     */
    public function camelizeWithUpperFirstCharProvider(): array
    {
        // exit
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
