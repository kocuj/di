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
    public function testWrongArgument(): void
    {
        // ---- ARRANGE ----

        $id = 'ThisService';

        $container = $this->prophesize(ContainerInterface::class);

        $argument = [
            'somewrongkey' => 'something',
        ];

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();

        // ---- ACT ----

        new Service($containerReveal, $id, $argument);
    }

    /**
     * Testing parsing service as argument
     *
     * @throws Exception
     */
    public function testParseService(): void
    {
        // ---- ARRANGE ----

        $id = 'ThisService';
        $otherId = 'OtherService';

        $service = $this->prophesize(ServiceInterface::class);

        $container = $this->prophesize(ContainerInterface::class);

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();
        /** @var ContainerInterface $container */

        $serviceReveal = $service->reveal();

        $container->get($otherId)->willReturn($serviceReveal);

        $argument = [
            'value' => $otherId,
        ];

        // ---- ACT ----

        $argumentParserService = new Service($containerReveal, $id, $argument);
        $parsedArg = $argumentParserService->parse();

        // ---- ASSERT ----

        // check if output service is based on input service identifier
        $this->assertSame($serviceReveal, $parsedArg);
    }

    /**
     * Testing parsing the same service twice as argument
     *
     * @expectedException Exception
     */
    public function testParseTheSameService(): void
    {
        // ---- ARRANGE ----

        $id = 'ThisService';

        $service = $this->prophesize(ServiceInterface::class);

        $container = $this->prophesize(ContainerInterface::class);

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();
        /** @var ContainerInterface $container */

        $serviceReveal = $service->reveal();

        $container->get($id)->willReturn($serviceReveal);

        $argument = [
            'value' => $id,
        ];

        // ---- ACT ----

        $argumentParserService = new Service($containerReveal, $id, $argument);
        $argumentParserService->parse();
    }
}
