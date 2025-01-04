<?php

/*
 * ContainerTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Unit\Container;

use Kocuj\Di\Core\Container\Container;
use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\Container\Exception;
use Kocuj\Di\Core\Container\NotFoundException;
use Kocuj\Di\Core\Service\ServiceFactoryInterface;
use Kocuj\Di\Core\Service\ServiceInterface;
use Kocuj\Di\Core\Service\ServiceType;
use Kocuj\Di\Core\ServiceIdDecorator\ServiceIdDecoratorInterface;
use Kocuj\Di\Tests\Fixtures\FakeService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @package Kocuj\Di\Tests
 */
class ContainerTest extends TestCase
{
    /**
     * @var ObjectProphecy|ServiceIdDecoratorInterface|null
     */
    private $serviceIdDecorator = null;

    /**
     * @var ObjectProphecy|ServiceInterface|null
     */
    private $service = null;

    private ?FakeService $fakeService = null;

    /**
     * @var ObjectProphecy|ServiceFactoryInterface|null
     */
    private $serviceFactory = null;

    /**
     * Testing cloning container; any service in the cloned container should have the same identifier and should be the same type and instance as in the original container
     *
     * @dataProvider cloneProvider
     */
    public function testClone(
        ServiceType $serviceType,
        string $serviceId,
        string $decoratedServiceId,
        string $decoratedServiceIdForGetMethod
    ): void {
        // ---- ARRANGE ----

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        $clonedObject = new FakeService();

        /** @var ServiceInterface $clonedService */
        $clonedService = $this->prophesize(ServiceInterface::class);
        $clonedService->getService()->willReturn($clonedObject);

        /** @var ContainerInterface $containerInterface */
        $containerInterface = Argument::type(ContainerInterface::class);

        /** @var MethodProphecy $serviceFactoryCreate */
        $serviceFactoryCreate = $this->serviceFactory->create($containerInterface, $serviceType, $decoratedServiceId,
            FakeService::class);
        $serviceFactoryCreate->willReturn($clonedService);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);

        $container->add($serviceType, $serviceId, FakeService::class);

        $clonedContainer = clone $container;

        // ---- ASSERT ----

        $this->assertNotSame($clonedContainer, $container);
        $this->assertEquals($clonedContainer->count(), $container->count());
        $this->assertEquals(count($clonedContainer), count($container));
        $this->assertSame($clonedContainer->get($serviceId), $container->get($serviceId));
    }

    public function cloneProvider(): array
    {
        return [
            [
                new ServiceType(ServiceType::STANDARD),
                'thisService',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'thisService',
                'thisService',
                'ThisService',
            ]
        ];
    }

    /**
     * @dataProvider addCheckTypeHasProvider
     */
    public function testAdd(
        ServiceType $serviceType,
        string $serviceId,
        string $decoratedServiceId,
        string $decoratedServiceIdForGetMethod
    ): void {
        // ---- ARRANGE ----

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);

        $objectReturnedBySet = $container->add($serviceType, $serviceId, FakeService::class);
        $returnedService = $container->get($serviceId);
        $returnedServiceByDecoratedId = $container->get($decoratedServiceId);

        // ---- ASSERT ----

        $this->assertSame($container, $objectReturnedBySet);
        $this->assertSame($this->fakeService, $returnedService);
        $this->assertSame($this->fakeService, $returnedServiceByDecoratedId);
    }

    /**
     * @dataProvider addCheckTypeHasProvider
     */
    public function testCheckType(
        ServiceType $serviceType,
        string $serviceId,
        string $decoratedServiceId,
        string $decoratedServiceIdForGetMethod
    ): void {
        // ---- ARRANGE ----

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);
        $container->add($serviceType, $serviceId, FakeService::class);

        // ---- ASSERT ----

        $this->assertTrue($container->checkType($serviceId, $serviceType));
        $this->assertTrue($container->checkType($decoratedServiceId, $serviceType));
    }

    /**
     * @dataProvider addCheckTypeHasProvider
     */
    public function testHas(
        ServiceType $serviceType,
        string $serviceId,
        string $decoratedServiceId,
        string $decoratedServiceIdForGetMethod
    ): void {
        // ---- ARRANGE ----

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);
        $container->add($serviceType, $serviceId, FakeService::class);

        // ---- ASSERT ----

        $this->assertTrue($container->has($serviceId));
        $this->assertTrue($container->has($decoratedServiceId));
    }

    public function addCheckTypeHasProvider(): array
    {
        return [
            [
                new ServiceType(ServiceType::STANDARD),
                'thisService',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this-service',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this_service',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'ThisService',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this-service',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this_service',
                'thisService',
                'ThisService',
            ]
        ];
    }

    /**
     * @dataProvider servicesTypesProvider
     */
    public function testCount(ServiceType $serviceType): void
    {
        // ---- ARRANGE ----

        $maxIterations = 10;

        $serviceId = 'service';
        $decoratedServiceId = 'service';
        $decoratedServiceIdForGetMethod = 'Service';

        $services = [];
        for ($i = 1; $i < $maxIterations; $i++) {
            $serviceIdForIteration = $serviceId . $i;
            $decoratedServiceIdForIteration = $decoratedServiceId . $i;

            $services[$serviceIdForIteration] = $decoratedServiceIdForIteration;

            $this->prepareService(
                $serviceType,
                $serviceIdForIteration,
                $decoratedServiceIdForIteration,
                $decoratedServiceIdForGetMethod
            );
        }

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        // ---- ACT ----

        for ($i = 0; $i < $maxIterations; $i++) {
            $containers[$i] = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);
            if ($i > 0) {
                for ($j = 1; $j <= $i; $j++) {
                    $containers[$i]->add($serviceType, $serviceId . $j, FakeService::class);
                }
            }
        }

        // ---- ASSERT ----

        $this->assertEquals(0, $containers[0]->count());
        $this->assertEquals(0, count($containers[0]));

        for ($i = 1; $i < $maxIterations; $i++) {
            $this->assertEquals($i, $containers[$i]->count());
            $this->assertEquals($i, count($containers[$i]));
        }
    }

    /**
     * @dataProvider callMethodProvider
     */
    public function testCallMethod(
        ServiceType $serviceType,
        string $serviceId,
        string $decoratedServiceId,
        string $decoratedServiceIdForGetMethod,
        string $callMethod
    ): void {
        // ---- ARRANGE ----

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);

        $objectReturnedBySet = $container->add($serviceType, $serviceId, FakeService::class);
        $returnedService = call_user_func([
            $container,
            $callMethod
        ]);

        // ---- ASSERT ----

        $this->assertSame($container, $objectReturnedBySet);
        $this->assertSame($this->fakeService, $returnedService);
    }

    public function callMethodProvider(): array
    {
        return [
            [
                new ServiceType(ServiceType::STANDARD),
                'ThisService',
                'thisService',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this-service',
                'thisService',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this_service',
                'thisService',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'ThisService',
                'thisService',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this-service',
                'thisService',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this_service',
                'thisService',
                'ThisService',
                'getThisService'
            ]
        ];
    }

    /**
     * @dataProvider getMethodProvider
     */
    public function testGetMethod(
        ServiceType $serviceType,
        string $serviceId,
        string $decoratedServiceId,
        string $decoratedServiceIdForGetMethod
    ): void {
        // ---- ARRANGE ----

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);

        $objectReturnedBySet = $container->add($serviceType, $serviceId, FakeService::class);
        $returnedService = $container->get($serviceId);

        // ---- ASSERT ----

        $this->assertSame($container, $objectReturnedBySet);
        $this->assertSame($this->fakeService, $returnedService);
    }

    public function getMethodProvider(): array
    {
        return [
            [
                new ServiceType(ServiceType::STANDARD),
                'ThisService',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this-service',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this_service',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'ThisService',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this-service',
                'thisService',
                'ThisService',
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this_service',
                'thisService',
                'ThisService',
            ]
        ];
    }

    /**
     * @dataProvider servicesTypesProvider
     */
    public function testErrorAddAlreadyExists(ServiceType $serviceType): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';
        $decoratedServiceId = 'service';
        $decoratedServiceIdForGetMethod = 'Service';

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        $this->expectException(\Kocuj\Di\Core\Container\Exception::class);

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);
        $container->add($serviceType, $serviceId, FakeService::class);
        $container->add($serviceType, $serviceId, FakeService::class);
    }

    /**
     * @dataProvider servicesTypesProvider
     */
    public function testErrorAddWithWrongGet(ServiceType $serviceType): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $decoratedServiceIdForGetMethod = 'Service';
        $wrongServiceId = 'OtherService';

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var MethodProphecy $serviceIdDecoratorDecorate */
        $serviceIdDecoratorDecorate = $this->serviceIdDecorator->decorateForServiceId($wrongServiceId);
        $serviceIdDecoratorDecorate->willReturn($wrongServiceId);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        $this->expectException(\Kocuj\Di\Core\Container\NotFoundException::class);

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);
        $container->add($serviceType, $serviceId, FakeService::class);
        $container->get($wrongServiceId);
    }

    /**
     * @dataProvider servicesTypesProvider
     */
    public function testErrorWrongCallMethod(ServiceType $serviceType): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $decoratedServiceIdForGetMethod = 'Service';

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        $this->expectException(\PHPUnit\Framework\Error\Error::class);

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);
        call_user_func([$container, 'wrongMethodSupportedByCall']);
    }

    /**
     * @dataProvider servicesTypesProvider
     */
    public function testCallMethodWithArguments(ServiceType $serviceType): void
    {
        // ---- ARRANGE ----

        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $decoratedServiceIdForGetMethod = 'Service';

        $this->prepareService($serviceType, $serviceId, $decoratedServiceId, $decoratedServiceIdForGetMethod);

        /** @var ServiceIdDecoratorInterface $serviceIdDecoratorReveal */
        $serviceIdDecoratorReveal = $this->serviceIdDecorator->reveal();

        /** @var ServiceFactoryInterface $serviceFactoryReveal */
        $serviceFactoryReveal = $this->serviceFactory->reveal();

        $this->expectException(\Kocuj\Di\Core\Container\Exception::class);

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);

        $container->add($serviceType, $serviceId, FakeService::class);
        call_user_func_array([
            $container,
            'get' . $decoratedServiceId
        ], [
            1
        ]);
    }

    public function servicesTypesProvider(): array
    {
        return [
            [
                new ServiceType(ServiceType::STANDARD)
            ],
            [
                new ServiceType(ServiceType::SHARED)
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->serviceIdDecorator = $this->prophesize(ServiceIdDecoratorInterface::class);

        $this->fakeService = new FakeService();

        $this->service = $this->prophesize(ServiceInterface::class);

        /** @var MethodProphecy $serviceGetService */
        $serviceGetService = $this->service->getService();
        $serviceGetService->willReturn($this->fakeService);

        $this->serviceFactory = $this->prophesize(ServiceFactoryInterface::class);
    }

    private function prepareService(
        ServiceType $serviceType,
        string $serviceId,
        string $decoratedServiceId,
        string $decoratedServiceIdForGetMethod
    ): void {
        /** @var ContainerInterface $containerInterface */
        $containerInterface = Argument::type(ContainerInterface::class);

        /** @var MethodProphecy $serviceIdDecoratorDecorate */
        $serviceIdDecoratorDecorate = $this->serviceIdDecorator->decorateForServiceId($serviceId);
        $serviceIdDecoratorDecorate->willReturn($decoratedServiceId);

        $serviceIdDecoratorDecorate = $this->serviceIdDecorator->decorateForServiceId($decoratedServiceId);
        $serviceIdDecoratorDecorate->willReturn($decoratedServiceId);

        $serviceIdDecoratorDecorate = $this->serviceIdDecorator->decorateForServiceId($decoratedServiceIdForGetMethod);
        $serviceIdDecoratorDecorate->willReturn($decoratedServiceId);

        /** @var MethodProphecy $serviceIdDecoratorDecorateForGetMethod */
        $serviceIdDecoratorDecorateForGetMethod = $this->serviceIdDecorator->decorateForGetMethod($serviceId);
        $serviceIdDecoratorDecorateForGetMethod->willReturn($decoratedServiceIdForGetMethod);

        $serviceIdDecoratorDecorateForGetMethod = $this->serviceIdDecorator->decorateForGetMethod($decoratedServiceIdForGetMethod);
        $serviceIdDecoratorDecorateForGetMethod->willReturn($decoratedServiceIdForGetMethod);

        /** @var MethodProphecy $serviceFactoryCreate */
        $serviceFactoryCreate = $this->serviceFactory->create($containerInterface, $serviceType,
            $decoratedServiceId, FakeService::class);
        $serviceFactoryCreate->willReturn($this->service);
    }
}
