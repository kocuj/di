<?php

/**
 * ServiceTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\Tests\ArgumentParser\ServiceTest;

use Kocuj\Di\ArgumentParser\Service\Service;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\ServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Service object
 *
 * @package Kocuj\Di\Tests\ArgumentParser\ServiceTest
 */
class ServiceTest extends TestCase
{
    /**
     * Testing argument for old version
     *
     * @expectedException \PHPUnit\Framework\Error\Error
     */
    public function testOldVersionArgument()
    {
        // arrange
        $id = 'ThisService';
        $otherId = 'OtherService';
        $service = $this->prophesize(ServiceInterface::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->get($id)->willReturn($service->reveal());
        $argument = [
            'type' => 'service',
            'service' => $otherId
        ];

        // act
        $argumentParserService = new Service($container->reveal(), $id, $argument);
    }

    /**
     * Testing wrong argument
     *
     * @expectedException \Kocuj\Di\ArgumentParser\Exception
     */
    public function testWrongArgument()
    {
        // arrange
        $id = 'ThisService';
        $service = $this->prophesize(ServiceInterface::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->get($id)->willReturn($service->reveal());
        $argument = [
            'type' => 'service'
        ];

        // act
        $argumentParserService = new Service($container->reveal(), $id, $argument);
    }

    /**
     * Testing parsing service as argument
     */
    public function testParseService()
    {
        // arrange
        $id = 'ThisService';
        $otherId = 'OtherService';
        $service = $this->prophesize(ServiceInterface::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->get($otherId)->willReturn($service->reveal());
        $argument = [
            'type' => 'service',
            'value' => $otherId
        ];

        // act
        $argumentParserService = new Service($container->reveal(), $id, $argument);
        $parsedArg = $argumentParserService->parse();

        // assert
        $this->assertTrue($parsedArg instanceof ServiceInterface);
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
        $service = $this->prophesize(ServiceInterface::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->get($id)->willReturn($service->reveal());
        $argument = [
            'type' => 'service',
            'value' => $id
        ];

        // act
        $argumentParserService = new Service($container->reveal(), $id, $argument);
        $argumentParserService->parse();
    }
}
