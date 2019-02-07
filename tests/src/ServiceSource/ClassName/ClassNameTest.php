<?php

/**
 * ClassNameTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Tests\ServiceSource\ClassName;

use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\ServiceSource\ClassName\ArgumentParser\ArgumentParserFactoryInterface;
use Kocuj\Di\ServiceSource\ClassName\ArgumentParser\ArgumentParserInterface;
use Kocuj\Di\ServiceSource\ClassName\ClassName;
use Kocuj\Di\ServiceSource\ClassName\ServiceFactoryInterface;
use Kocuj\Di\ServiceSource\Exception;
use Kocuj\Di\TestsLib\FakeService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Finder\Expression\ValueInterface;

/**
 * Tests for ClassName object
 *
 * @package Kocuj\Di\Tests\ServiceSource\ClassName
 */
class ClassNameTest extends TestCase
{
    /**
     * Testing wrong service source
     *
     * @throws Exception
     * @expectedException Exception
     */
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

        // ---- ACT ----

        new ClassName($serviceFactoryReveal, $argumentParserFactoryReveal, $containerReveal, $serviceId,
            $serviceSource);
    }

    /**
     * Provider for wrong service source
     *
     * @return array Data for services types
     * @throws \Exception
     */
    public function wrongServiceSourceProvider(): array
    {
        // exit
        return [
            [
                new FakeService(),
            ],
        ];
    }

    /**
     * Testing wrong service source
     *
     * @param mixed $serviceSource Service source
     * @throws Exception
     * @expectedException Exception
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

        // ---- ACT ----

        $className = new ClassName($serviceFactoryReveal, $argumentParserFactoryReveal, $containerReveal, $serviceId,
            $serviceSource);
        $className->resolve();
    }

    /**
     * Provider for wrong service source
     *
     * @return array Data for services types
     * @throws \Exception
     */
    public function resolveWrongServiceSourceProvider(): array
    {
        // exit
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

    /**
     * Testing resolving service from string
     *
     * @throws Exception
     */
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

        // check if output service is based on input service identifier
        $this->assertEquals(FakeService::class, get_class($resolve));
    }

    /**
     * Testing resolving service from array
     *
     * @throws Exception
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

        // check if output service is based on input service identifier
        $this->assertEquals(FakeService::class, get_class($resolve));
    }

    /**
     * Provider for testing resolving service from array
     *
     * @return array Data for testing resolving service from array
     */
    public function resolveFromArrayProvider(): array
    {
        // exit
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
