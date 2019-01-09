<?php

/**
 * ServiceTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Tests\ServiceSource\ClassName\ArgumentParser\Service;

use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\ServiceInterface;
use Kocuj\Di\ServiceSource\ClassName\ArgumentParser\Service\Service;
use Kocuj\Di\ServiceSource\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Service object
 *
 * @package Kocuj\Di\Tests\ServiceSource\ClassName\ArgumentParser\Service
 */
class ServiceTest extends TestCase
{
    /**
     * Testing wrong argument
     *
     * @expectedException Exception
     */
    public function testWrongArgument()
    {
        // ---- ARRANGE ----

        $id = 'ThisService';

        $service = $this->prophesize(ServiceInterface::class);

        $container = $this->prophesize(ContainerInterface::class);
        /** @var ContainerInterface $container */

        $serviceReveal = $service->reveal();

        $argument = [
            'somewrongkey' => 'something',
        ];

        // ---- ACT ----

        $containerReveal = $container->reveal();
        /** @var ContainerInterface $containerReveal */

        $argumentParserService = new Service($containerReveal, $id, $argument);
    }

    /**
     * Testing parsing service as argument
     *
     * @throws Exception
     */
    public function testParseService()
    {
        // ---- ARRANGE ----

        $id = 'ThisService';
        $otherId = 'OtherService';

        $service = $this->prophesize(ServiceInterface::class);

        $container = $this->prophesize(ContainerInterface::class);
        /** @var ContainerInterface $container */

        $serviceReveal = $service->reveal();

        $container->get($otherId)->willReturn($serviceReveal);

        $argument = [
            'value' => $otherId,
        ];

        // ---- ACT ----

        $containerReveal = $container->reveal();
        /** @var ContainerInterface $containerReveal */

        $argumentParserService = new Service($containerReveal, $id, $argument);
        $parsedArg = $argumentParserService->parse();

        // ---- ASSERT ----

        // check if correct service has been returned
        $this->assertSame($serviceReveal, $parsedArg);
    }

    /**
     * Testing parsing the same service twice as argument
     *
     * @expectedException Exception
     */
    public function testParseTheSameService()
    {
        // ---- ARRANGE ----

        $id = 'ThisService';

        $service = $this->prophesize(ServiceInterface::class);

        $container = $this->prophesize(ContainerInterface::class);
        /** @var ContainerInterface $container */

        $serviceReveal = $service->reveal();

        $container->get($id)->willReturn($serviceReveal);

        $argument = [
            'value' => $id,
        ];

        // ---- ACT ----

        $containerReveal = $container->reveal();
        /** @var ContainerInterface $containerReveal */

        $argumentParserService = new Service($containerReveal, $id, $argument);
        $argumentParserService->parse();
    }
}
