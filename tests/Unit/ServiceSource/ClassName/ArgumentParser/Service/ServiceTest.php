<?php

/*
 * ServiceTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Unit\ServiceSource\ClassName\ArgumentParser\Service;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\Service\ServiceInterface;
use Kocuj\Di\Core\ServiceSource\____ClassName\ArgumentParser\Service\Service;
use Kocuj\Di\Core\ServiceSource\Exception;
use PHPUnit\Framework\TestCase;

/**
 * @package Kocuj\Di\Tests
 */
class ServiceTest extends TestCase
{
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

        $this->expectException(Exception::class);

        // ---- ACT ----

        new Service($containerReveal, $id, $argument);
    }

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

        $this->assertSame($serviceReveal, $parsedArg);
    }

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

        $this->expectException(Exception::class);

        // ---- ACT ----

        $argumentParserService = new Service($containerReveal, $id, $argument);
        $argumentParserService->parse();
    }
}
