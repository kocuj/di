<?php

/**
 * ContainerTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Tests\Unit\Container;

use Kocuj\Di\Container\Container;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Container\Exception;
use Kocuj\Di\Container\NotFoundException;
use Kocuj\Di\Service\ServiceFactoryInterface;
use Kocuj\Di\Service\ServiceInterface;
use Kocuj\Di\Service\ServiceType;
use Kocuj\Di\ServiceIdDecorator\ServiceIdDecoratorInterface;
use Kocuj\Di\Tests\Fixtures\FakeService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Tests for Container object
 *
 * @package Kocuj\Di\Tests\Container
 */
class ContainerTest extends TestCase
{
    /**
     * Service identifier decorator
     *
     * @var ObjectProphecy|ServiceIdDecoratorInterface|null
     */
    private $serviceIdDecorator = null;

    /**
     * Service creator
     *
     * @var ObjectProphecy|ServiceInterface|null
     */
    private $service = null;

    /**
     * Fake service
     */
    private ?FakeService $fakeService = null;

    /**
     * Service factory
     *
     * @var ObjectProphecy|ServiceFactoryInterface|null
     */
    private $serviceFactory = null;

    /**
     * Testing cloning container; any service in the cloned container should have the same identifier and should be the same type and instance as in the original container
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @throws Exception
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

        // check if containers are not the same
        $this->assertNotSame($clonedContainer, $container);
        $this->assertEquals($clonedContainer->count(), $container->count());
        $this->assertEquals(count($clonedContainer), count($container));
        $this->assertSame($clonedContainer->get($serviceId), $container->get($serviceId));
    }

    /**
     * Provider for testing cloning container
     *
     * @return array Data for testing cloning container
     * @throws \Exception
     */
    public function cloneProvider(): array
    {
        // exit
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
     * Testing adding standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @dataProvider addCheckTypeHasProvider
     * @throws Exception
     * @throws NotFoundException
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

        // check if the same container has been returned by this method
        $this->assertSame($container, $objectReturnedBySet);
        // check if service has been added
        $this->assertSame($this->fakeService, $returnedService);
        // check if service has been added
        $this->assertSame($this->fakeService, $returnedServiceByDecoratedId);
    }

    /**
     * Testing checking type of standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @throws Exception
     * @throws NotFoundException
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

        // check if service has the correct type
        $this->assertTrue($container->checkType($serviceId, $serviceType));
        $this->assertTrue($container->checkType($decoratedServiceId, $serviceType));
    }

    /**
     * Testing checking standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @throws Exception
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

        // check if there is a service in container
        $this->assertTrue($container->has($serviceId));
        // check if there is a service with decorated identifier in container
        $this->assertTrue($container->has($decoratedServiceId));
    }

    /**
     * Provider for testing adding and checking standard and shared services
     *
     * @return array Data for testing adding and checking standard and shared services
     * @throws \Exception
     */
    public function addCheckTypeHasProvider(): array
    {
        // exit
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
     * Testing checking services count
     *
     * @param ServiceType $serviceType Service type
     * @throws Exception
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

        // check services count
        $this->assertEquals(0, $containers[0]->count());
        $this->assertEquals(0, count($containers[0]));

        for ($i = 1; $i < $maxIterations; $i++) {
            // check services count
            $this->assertEquals($i, $containers[$i]->count());
            $this->assertEquals($i, count($containers[$i]));
        }
    }

    /**
     * Testing get standard or shared service by "__call" method
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @param string $callMethod Method to call to get service
     * @throws Exception
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

        // check if the same container has been returned by this method
        $this->assertSame($container, $objectReturnedBySet);
        // check if the same service has been returned by this method
        $this->assertSame($this->fakeService, $returnedService);
    }

    /**
     * Provider for testing standard and shared services by "__call" method
     *
     * @return array Data for testing standard and shared services
     * @throws \Exception
     */
    public function callMethodProvider(): array
    {
        // exit
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
     * Testing get standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @param string $callMethod Method to call to get service
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

        // check if the same container has been returned by this method
        $this->assertSame($container, $objectReturnedBySet);
        // check if the same service has been returned by this method
        $this->assertSame($this->fakeService, $returnedService);
    }

    /**
     * Provider for testing standard and shared services
     *
     * @return array Data for testing standard and shared services
     * @throws \Exception
     */
    public function getMethodProvider(): array
    {
        // exit
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
     * Testing for adding service which already exists
     *
     * @param ServiceType $serviceType Service type
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

        $this->expectException(\Kocuj\Di\Container\Exception::class);

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);
        $container->add($serviceType, $serviceId, FakeService::class);
        $container->add($serviceType, $serviceId, FakeService::class);
    }

    /**
     * Testing wrong service identifier to get after creating standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @throws Exception
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

        $this->expectException(\Kocuj\Di\Container\NotFoundException::class);

        // ---- ACT ----

        $container = new Container($serviceIdDecoratorReveal, $serviceFactoryReveal);
        $container->add($serviceType, $serviceId, FakeService::class);
        $container->get($wrongServiceId);
    }

    /**
     * Testing calling wrong method
     *
     * @param ServiceType $serviceType Service type
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
     * Testing calling with arguments
     *
     * @param ServiceType $serviceType Service type
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

        $this->expectException(\Kocuj\Di\Container\Exception::class);

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

    /**
     * Provider for services types
     *
     * @return array Data for services types
     * @throws \Exception
     */
    public function servicesTypesProvider(): array
    {
        // exit
        return [
            [
                new ServiceType(ServiceType::STANDARD)
            ],
            [
                new ServiceType(ServiceType::SHARED)
            ]
        ];
    }

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

    /**
     * Preparing objects for testing
     *
     * @param ServiceType $serviceType
     * @param array $services
     */
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
