<?php

/**
 * ArgumentParserTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di_tests
 */
namespace Kocuj\Di\Tests;

use Kocuj\Di\ArgumentParser\ArgumentParser;
use Kocuj\Di\Container\IContainer;
use Kocuj\Di\Service\IService;
use PHPUnit\Framework\TestCase;

/**
 * Tests for ArgumentParser object
 */
class ArgumentParserTest extends TestCase
{

    /**
     * Test parsing value as argument
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
        $id = 'ThisService';
        $container = $this->prophesize(IContainer::class);
        $argument = [
            'type' => 'value',
            'value' => $value
        ];
        
        // act
        $argumentParser = new ArgumentParser();
        $parsedArg = $argumentParser->parse($container->reveal(), $id, $argument);
        
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

    /**
     * Testing parsing service as argument
     */
    public function testParseService()
    {
        // arrange
        $id = 'ThisService';
        $otherId = 'OtherService';
        $service = $this->prophesize(IService::class);
        $container = $this->prophesize(IContainer::class);
        $container->get($otherId)->willReturn($service->reveal());
        $argument = [
            'type' => 'service',
            'service' => $otherId
        ];
        
        // act
        $argumentParser = new ArgumentParser();
        $parsedArg = $argumentParser->parse($container->reveal(), $id, $argument);
        
        // assert
        $this->assertTrue($parsedArg instanceof IService);
    }

    /**
     * Testing parsing the same service twice as argument
     *
     * @expectedException \Kocuj\Di\ArgumentParser\Exception
     */
    public function testParseTheSameService()
    {
        // arrange
        $id = 'ThisService';
        $service = $this->prophesize(IService::class);
        $container = $this->prophesize(IContainer::class);
        $container->get($id)->willReturn($service->reveal());
        $argument = [
            'type' => 'service',
            'service' => $id
        ];
        
        // act
        $argumentParser = new ArgumentParser();
        $argumentParser->parse($container->reveal(), $id, $argument);
    }

    /**
     * Testing parsing argument of unknown type
     *
     * @expectedException \Kocuj\Di\ArgumentParser\Exception
     */
    public function testParseUnknown()
    {
        // arrange
        $id = 'ThisService';
        $container = $this->prophesize(IContainer::class);
        $argument = [
            'type' => 'something_unknown'
        ];
        
        // act
        $argumentParser = new ArgumentParser();
        $argumentParser->parse($container->reveal(), $id, $argument);
    }
}
