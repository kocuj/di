<?php

/**
 * ClassNameTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Unit\ServiceSource\ClassName;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\ServiceSource\____ClassName\ArgumentParser\ArgumentParserFactoryInterface;
use Kocuj\Di\Core\ServiceSource\____ClassName\ArgumentParser\ArgumentParserInterface;
use Kocuj\Di\Core\ServiceSource\____ClassName\ClassName;
use Kocuj\Di\Core\ServiceSource\____ClassName\ServiceFactoryInterface;
use Kocuj\Di\Core\ServiceSource\Exception;
use Kocuj\Di\Tests\Fixtures\FakeService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @package Kocuj\Di\Tests\ServiceSource\ClassName
 */
class ClassNameTest extends TestCase
{
    public function testWrongServiceSource(): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';
        $serviceSource = new FakeService();

        $serviceFactory = $this->prophesize(ServiceFactoryInterface::class);

        $argumentParserFactory = $this->prophesize(ArgumentParserFactoryInterface::class);

        $container = $this->prophesize(ContainerInterface::class);

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $serviceFactory->reveal();

        /** @var ArgumentParserFactoryInterface $argumentParserFactoryReveal */
        $argumentParserFactoryReveal = $argumentParserFactory->reveal();

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();

        $this->expectException(Exception::class);

        // ---- ACT ----

        new ClassName($serviceFactoryReveal, $argumentParserFactoryReveal, $containerReveal, $serviceId,
            $serviceSource);
    }

    public function testServiceSourceClassNotExists(): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';
        $serviceSource = 'ClassNotExists';

        $serviceFactory = $this->prophesize(ServiceFactoryInterface::class);

        $argumentParserFactory = $this->prophesize(ArgumentParserFactoryInterface::class);

        $container = $this->prophesize(ContainerInterface::class);

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $serviceFactory->reveal();

        /** @var ArgumentParserFactoryInterface $argumentParserFactoryReveal */
        $argumentParserFactoryReveal = $argumentParserFactory->reveal();

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();

        $this->expectException(Exception::class);

        // ---- ACT ----

        $className = new ClassName($serviceFactoryReveal, $argumentParserFactoryReveal, $containerReveal, $serviceId,
            $serviceSource);
        $className->resolve();
    }

    public function wrongServiceSourceProvider(): array
    {
        return [
            [
                new FakeService(),
            ],
        ];
    }

    /**
     * @param mixed $serviceSource Service source
     * @dataProvider resolveWrongServiceSourceProvider
     */
    public function testResolveWrongServiceSource($serviceSource): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';

        $serviceFactory = $this->prophesize(ServiceFactoryInterface::class);

        $argumentParserFactory = $this->prophesize(ArgumentParserFactoryInterface::class);

        $container = $this->prophesize(ContainerInterface::class);

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $serviceFactory->reveal();

        /** @var ArgumentParserFactoryInterface $argumentParserFactoryReveal */
        $argumentParserFactoryReveal = $argumentParserFactory->reveal();

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();

        $this->expectException(Exception::class);

        // ---- ACT ----

        $className = new ClassName($serviceFactoryReveal, $argumentParserFactoryReveal, $containerReveal, $serviceId,
            $serviceSource);
        $className->resolve();
    }

    public function resolveWrongServiceSourceProvider(): array
    {
        return [
            [
                [
                    'noClassName' => '',
                ]
            ],
            [
                [
                    'className' => 'NoClass',
                ]
            ],
            [
                [
                    'className' => FakeService::class,
                    'arguments' => 'noArray',
                ]
            ],
        ];
    }

    public function testResolveFromString(): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';
        $serviceSource = FakeService::class;

        /** @var ServiceFactoryInterface $serviceFactory */
        $serviceFactory = $this->prophesize(ServiceFactoryInterface::class);

        /** @var ObjectProphecy $serviceFactory */

        /** @var MethodProphecy $serviceFactoryCreate */
        $serviceFactoryCreate = $serviceFactory->create(FakeService::class, []);
        $serviceFactoryCreate->willReturn(new FakeService());

        $argumentParserFactory = $this->prophesize(ArgumentParserFactoryInterface::class);

        $container = $this->prophesize(ContainerInterface::class);

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $serviceFactory->reveal();

        /** @var ArgumentParserFactoryInterface $argumentParserFactoryReveal */
        $argumentParserFactoryReveal = $argumentParserFactory->reveal();

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();

        // ---- ACT ----

        $className = new ClassName($serviceFactoryReveal, $argumentParserFactoryReveal, $containerReveal, $serviceId,
            $serviceSource);
        $resolve = $className->resolve();

        // ---- ASSERT ----

        $this->assertEquals(FakeService::class, get_class($resolve));
    }

    /**
     * @dataProvider resolveFromArrayProvider
     */
    public function testResolveFromArray(array $arguments): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';
        $serviceSource = [
            'className' => FakeService::class,
            'arguments' => $arguments,
        ];

        $container = $this->prophesize(ContainerInterface::class);

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();

        /** @var ArgumentParserFactoryInterface $argumentParserFactory */
        $argumentParserFactory = $this->prophesize(ArgumentParserFactoryInterface::class);

        $parsedArgs = [];

        foreach ($arguments as $argument) {
            /** @var ValueInterface $value */
            $value = $this->prophesize(ValueInterface::class);

            /** @var ArgumentParserInterface $argumentParser */
            $argumentParser = $this->prophesize(ArgumentParserInterface::class);

            $argumentParserParse = $argumentParser->parse();
            $argumentParserParse->willReturn($value);

            /** @var ObjectProphecy $argumentParser */
            $argumentParserReveal = $argumentParser->reveal();

            /** @var MethodProphecy $argumentParserFactoryCreate */
            $argumentParserFactoryCreate = $argumentParserFactory->create($containerReveal, $serviceId, $argument);
            $argumentParserFactoryCreate->willReturn($argumentParserReveal);

            $parsedArgs[] = $value;
        }

        /** @var ObjectProphecy $argumentParserFactory */

        /** @var ArgumentParserFactoryInterface $argumentParserFactoryReveal */
        $argumentParserFactoryReveal = $argumentParserFactory->reveal();

        /** @var ServiceFactoryInterface $serviceFactory */
        $serviceFactory = $this->prophesize(ServiceFactoryInterface::class);

        /** @var MethodProphecy $serviceFactoryCreate */
        $serviceFactoryCreate = $serviceFactory->create(FakeService::class, $parsedArgs);
        $serviceFactoryCreate->willReturn(new FakeService());

        /** @var ObjectProphecy $serviceFactory */

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $serviceFactory->reveal();

        // ---- ACT ----

        $className = new ClassName($serviceFactoryReveal, $argumentParserFactoryReveal, $containerReveal, $serviceId,
            $serviceSource);
        $resolve = $className->resolve();

        // ---- ASSERT ----

        $this->assertEquals(FakeService::class, get_class($resolve));
    }

    public function resolveFromArrayProvider(): array
    {
        return [
            [
                [],
            ],
            [
                [
                    [
                        'type' => 'value',
                        'value' => 'arg1',
                    ],
                    [
                        'type' => 'value',
                        'value' => 2,
                    ],
                    [
                        'type' => 'service',
                        'value' => FakeService::class,
                    ]
                ],
            ]
        ];
    }
}
