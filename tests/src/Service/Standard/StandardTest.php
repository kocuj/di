<?php

/**
 * StandardTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\Tests\Service\Standard;

use Kocuj\Di\ArgumentParser\ArgumentParserFactoryInterface;
use Kocuj\Di\ArgumentParser\ArgumentParserInterface;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\Standard\Standard;
use Kocuj\Di\TestsLib\FakeService;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Standard object
 *
 * @package Kocuj\Di\Tests\Service\Standard
 */
class StandardTest extends TestCase
{
    /**
     * Testing get value for the selected service
     *
     * @param array $arguments Arguments
     * @dataProvider getServiceValueProvider
     */
    public function testGetServiceValue(array $arguments)
    {
        // ---- ASSERT ----

        $this->getServiceValueOrService(false, $arguments);
    }

    /**
     * Get value or service for the selected service
     *
     * @param bool $argumentsAreServices Arguments are services (true) or values (false)
     * @param array $arguments Arguments
     */
    private function getServiceValueOrService(bool $argumentsAreServices, array $arguments)
    {
        // ---- ARRANGE ----

        $id = 'ThisService';
        $container = $this->prophesize(ContainerInterface::class);
        $argumentParserFactory = $this->prophesize(ArgumentParserFactoryInterface::class);
        foreach ($arguments as $key => $argument) {
            $argumentParser = $this->prophesize(ArgumentParserInterface::class);
            if ($argumentsAreServices) {
                $argumentParserFactory->create($container, $id, $argument)->willReturn($argumentParser);
                $argumentParser->parse()->willReturn($argument['service']);
            } else {
                $argumentParserFactory->create($container, $id, $argument)->willReturn($argumentParser);
                $argumentParser->parse()->willReturn($argument['value']);
            }
        }
        $source = FakeService::class;

        // ---- ACT ----

        $standard = new Standard($argumentParserFactory->reveal(), $container->reveal(), $id, $source, $arguments);
        $service1 = $standard->getService();
        $service2 = $standard->getService();

        // ---- ASSERT ----

        $this->assertInstanceOf(FakeService::class, $service1);
        foreach ($arguments as $key => $argument) {
            if ($argumentsAreServices) {
                $this->assertEquals($argument['service'], $service1->getValue($key));
            } else {
                $this->assertEquals($argument['value'], $service1->getValue($key));
            }
        }
        $this->assertNotSame($service1, $service2);
    }

    /**
     * Testing get service for the selected service
     *
     * @param array $arguments Arguments
     * @dataProvider getServiceServiceProvider
     */
    public function testGetServiceService(array $arguments)
    {
        // ---- ASSERT ----

        $this->getServiceValueOrService(true, $arguments);
    }

    /**
     * Provider for testing get value for the selected service
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
     * Provider for testing get service for the selected service
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
