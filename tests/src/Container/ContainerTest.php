<?php

/**
 * ContainerTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\Tests\Container;

use Kocuj\Di\Container\Container;
use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\ServiceFactoryInterface;
use Kocuj\Di\Service\ServiceInterface;
use Kocuj\Di\Service\ServiceType;
use Kocuj\Di\ServiceIdDecorator\ServiceIdDecoratorInterface;
use Kocuj\Di\TestsLib\FakeService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

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
     * @var ServiceIdDecoratorInterface
     */
    private $serviceIdDecorator;

    /**
     * Fake service
     *
     * @var object
     */
    private $fakeService;

    /**
     * Service
     *
     * @var ServiceInterface
     */
    private $service;

    /**
     * Service factory
     *
     * @var ServiceFactoryInterface
     */
    private $serviceFactory;

    /**
     * Setup tests
     */
    public function setUp()
    {
        // arrange
        $this->serviceIdDecorator = $this->prophesize(ServiceIdDecoratorInterface::class);

        $this->fakeService = new FakeService();

        $this->service = $this->prophesize(ServiceInterface::class);
        $this->service->getService()->willReturn($this->fakeService);

        $this->serviceFactory = $this->prophesize(ServiceFactoryInterface::class);
    }

    /**
     * Testing cloning container
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @dataProvider cloneProvider
     */
    public function testClone(ServiceType $serviceType, string $serviceId, string $decoratedServiceId)
    {
        // arrange
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        $clonedObject = new FakeService();

        $clonedService = $this->prophesize(ServiceInterface::class);
        $clonedService->getService()->willReturn($clonedObject);
        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($clonedService);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->add($serviceType, $serviceId, FakeService::class, []);
        $returnedService = $container->get($serviceId);
        $clonedContainer = clone $container;
        $returnedClonedService = $container->get($serviceId);

        // assert
        $this->assertNotSame($returnedClonedService, $clonedService);
    }

    /**
     * Provider for testing cloning container
     *
     * @return array Data for testing cloning container
     */
    public function cloneProvider(): array
    {
        // exit
        return [
            [
                new ServiceType(ServiceType::STANDARD),
                'ThisService',
                'ThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'ThisService',
                'ThisService'
            ]
        ];
    }

    /**
     * Testing adding standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @dataProvider addHasCheckTypeProvider
     */
    public function testAdd(ServiceType $serviceType, string $serviceId, string $decoratedServiceId)
    {
        // arrange
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $objectReturnedBySet = $container->add($serviceType, $serviceId, FakeService::class, []);
        $returnedService = $container->get($serviceId);

        // assert
        $this->assertSame($container, $objectReturnedBySet);
        $this->assertSame($this->fakeService, $returnedService);
    }

    /**
     * Testing checking standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @dataProvider addHasCheckTypeProvider
     */
    public function testHas(ServiceType $serviceType, string $serviceId, string $decoratedServiceId)
    {
        // arrange
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $objectReturnedBySet = $container->add($serviceType, $serviceId, FakeService::class, []);
        $returnedService = $container->get($serviceId);

        // assert
        $this->assertTrue($container->has($serviceId));
        $this->assertTrue($container->has($decoratedServiceId));
    }

    /**
     * Testing checking type of standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @dataProvider addHasCheckTypeProvider
     */
    public function testCheckType(ServiceType $serviceType, string $serviceId, string $decoratedServiceId)
    {
        // arrange
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $objectReturnedBySet = $container->add($serviceType, $serviceId, FakeService::class, []);
        $returnedService = $container->get($serviceId);

        // assert
        $this->assertTrue($container->checkType($serviceId, $serviceType));
        $this->assertTrue($container->checkType($decoratedServiceId, $serviceType));
    }

    /**
     * Provider for testing adding and checking standard and shared services
     *
     * @return array Data for testing adding and checking standard and shared services
     */
    public function addHasCheckTypeProvider(): array
    {
        // exit
        return [
            [
                new ServiceType(ServiceType::STANDARD),
                'ThisService',
                'ThisService'
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this-service',
                'ThisService'
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this_service',
                'ThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'ThisService',
                'ThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this-service',
                'ThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this_service',
                'ThisService'
            ]
        ];
    }

    /**
     * Testing get type
     *
     * @param ServiceType $serviceType Service type
     * @dataProvider servicesTypesProvider
     * @expectedException \PHPUnit\Framework\Error\Error
     */
    public function testGetType(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->getType($decoratedServiceId);
    }

    /**
     * Testing standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @param string $serviceId Service identifier
     * @param string $decoratedServiceId Decorated service identifier
     * @param string $callMethod Method to call to get service
     * @dataProvider addCallMethodProvider
     */
    public function testAddCallMethod(
        ServiceType $serviceType,
        string $serviceId,
        string $decoratedServiceId,
        string $callMethod
    ) {
        // arrange
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $objectReturnedBySet = $container->add($serviceType, $serviceId, FakeService::class, []);
        $returnedService = call_user_func([
            $container,
            $callMethod
        ]);

        // assert
        $this->assertSame($container, $objectReturnedBySet);
        $this->assertSame($this->fakeService, $returnedService);
        $this->assertTrue($container->has($serviceId));
        $this->assertTrue($container->has($decoratedServiceId));
        $this->assertTrue($container->checkType($serviceId, $serviceType));
        $this->assertTrue($container->checkType($decoratedServiceId, $serviceType));
    }

    /**
     * Provider for testing standard and shared services
     *
     * @return array Data for testing standard and shared services
     */
    public function addCallMethodProvider(): array
    {
        // exit
        return [
            [
                new ServiceType(ServiceType::STANDARD),
                'ThisService',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this-service',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::STANDARD),
                'this_service',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'ThisService',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this-service',
                'ThisService',
                'getThisService'
            ],
            [
                new ServiceType(ServiceType::SHARED),
                'this_service',
                'ThisService',
                'getThisService'
            ]
        ];
    }

    /**
     * Testing service which already exists
     *
     * @param ServiceType $serviceType Service type
     * @dataProvider servicesTypesProvider
     * @expectedException \Kocuj\Di\Container\Exception
     */
    public function testAddAlreadyExists(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->add($serviceType, $serviceId, FakeService::class, []);
        $container->add($serviceType, $serviceId, FakeService::class, []);
    }

    /**
     * Testing wrong service identifier to get after creating standard or shared service
     *
     * @param ServiceType $serviceType Service type
     * @dataProvider servicesTypesProvider
     * @expectedException \Kocuj\Di\Container\NotFoundException
     */
    public function testAddWithWrongGet(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $wrongServiceId = 'OtherService';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($serviceId);
        $this->serviceIdDecorator->decorate($wrongServiceId)->willReturn($wrongServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $serviceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->add($serviceType, $serviceId, FakeService::class, []);
        $container->get($wrongServiceId);
    }

    /**
     * Testing calling wrong method
     *
     * @param ServiceType $serviceType Service type
     * @dataProvider servicesTypesProvider
     * @expectedException \PHPUnit\Framework\Error\Error
     */
    public function testWrongCallMethod(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->wrongMethodSupportedByCall();
    }

    /**
     * Testing calling with arguments
     *
     * @param ServiceType $serviceType Service type
     * @dataProvider servicesTypesProvider
     * @expectedException \Kocuj\Di\Container\Exception
     */
    public function testCallMethodWithArguments(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);

        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId,
            FakeService::class, [])->willReturn($this->service);

        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->add($serviceType, $serviceId, FakeService::class, []);
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
}
