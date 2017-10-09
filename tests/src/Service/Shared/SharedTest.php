<?php

/**
 * SharedTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di_tests
 */
namespace Kocuj\Di\Tests\Service\Shared;

use Kocuj\Di\ArgumentParser\IArgumentParser;
use Kocuj\Di\Container\IContainer;
use Kocuj\Di\Service\Shared\Shared;
use Kocuj\Di\TestsLib\FakeService;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Shared object
 */
class SharedTest extends TestCase
{

    /**
     * Get value or service for the selected service
     *
     * @param bool $argumentsAreServices
     *            Arguments are services (true) or values (false)
     * @param array $arguments
     *            Arguments
     */
    private function getServiceValueOrService(bool $argumentsAreServices, array $arguments)
    {
        // arrange
        $id = 'ThisService';
        $argumentParser = $this->prophesize(IArgumentParser::class);
        $container = $this->prophesize(IContainer::class);
        foreach ($arguments as $argument) {
            if ($argumentsAreServices) {
                $argumentParser->parse($container, $id, $argument)->willReturn($argument['service']);
            } else {
                $argumentParser->parse($container, $id, $argument)->willReturn($argument['value']);
            }
        }
        $source = FakeService::class;
        
        // act
        $shared = new Shared($argumentParser->reveal(), $container->reveal(), $id, $source, $arguments);
        $service1 = $shared->getService();
        $service2 = $shared->getService();
        
        // assert
        $this->assertInstanceOf(FakeService::class, $service1);
        foreach ($arguments as $key => $argument) {
            if ($argumentsAreServices) {
                $this->assertEquals($argument['service'], $service1->getValue($key));
            } else {
                $this->assertEquals($argument['value'], $service1->getValue($key));
            }
        }
        $this->assertSame($service1, $service2);
    }

    /**
     * Get value for the selected service
     *
     * @param array $arguments
     *            Arguments
     *            @dataProvider getServiceValueProvider
     */
    public function testGetServiceValue(array $arguments)
    {
        // assert
        $this->getServiceValueOrService(false, $arguments);
    }

    /**
     * Get service for the selected service
     *
     * @param array $arguments
     *            Arguments
     *            @dataProvider getServiceServiceProvider
     */
    public function testGetServiceService(array $arguments)
    {
        // assert
        $this->getServiceValueOrService(true, $arguments);
    }

    /**
     * Provider for get value for the selected service
     *
     * @return array Data for get value for the selected service
     */
    public function getServiceValueProvider(): array
    {
        // exit
        return [
            [
                []
            ],
            [
                [
                    [
                        'type' => 'value',
                        'value' => 1
                    ]
                ]
            ]
        ];
    }

    /**
     * Provider for get service for the selected service
     *
     * @return array Data for get service for the selected service
     */
    public function getServiceServiceProvider(): array
    {
        // exit
        return [
            [
                []
            ],
            [
                [
                    [
                        'type' => 'service',
                        'service' => new FakeService()
                    ]
                ]
            ]
        ];
    }
}
