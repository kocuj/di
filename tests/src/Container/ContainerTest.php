<?php

/**
 * ContainerTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di_tests
 */
namespace Kocuj\Di\Tests;

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
     * Test standard or shared service
     *
     * @param ServiceType $serviceType
     *            Service type
     * @param string $serviceId
     *            Service identifier
     * @param string $decoratedServiceId
     *            Decorated service identifier
     *            @dataProvider setProvider
     */
    public function testAdd(ServiceType $serviceType, string $serviceId, string $decoratedServiceId)
    {
        // arrange
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);
        
        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId, FakeService::class, [])->willReturn($this->service);
        
        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $objectReturnedBySet = $container->add($serviceType, $serviceId, FakeService::class, []);
        $returnedService = $container->get($serviceId);
        
        // assert
        $this->assertSame($container, $objectReturnedBySet);
        $this->assertSame($this->fakeService, $returnedService);
        $this->assertTrue($container->has($serviceId));
        $this->assertTrue($container->has($decoratedServiceId));
        $this->assertEquals($serviceType, $container->getType($serviceId));
        $this->assertEquals($serviceType, $container->getType($decoratedServiceId));
    }

    /**
     * Provider for testing standard and shared services
     *
     * @return array Data for testing standard and shared services
     */
    public function setProvider(): array
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
     * Test standard or shared service
     *
     * @param ServiceType $serviceType
     *            Service type
     * @param string $serviceId
     *            Service identifier
     * @param string $decoratedServiceId
     *            Decorated service identifier
     * @param string $callMethod
     *            Method to call to get service
     *            @dataProvider addCallMethodProvider
     */
    public function testAddCallMethod(ServiceType $serviceType, string $serviceId, string $decoratedServiceId, string $callMethod)
    {
        // arrange
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);
        
        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId, FakeService::class, [])->willReturn($this->service);
        
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
        $this->assertEquals($serviceType, $container->getType($serviceId));
        $this->assertEquals($serviceType, $container->getType($decoratedServiceId));
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
     * Test service which already exists
     *
     * @param ServiceType $serviceType
     *            Service type
     *            @dataProvider servicesTypesProvider
     *            @expectedException \Kocuj\Di\Container\ContainerException
     */
    public function testAddAlreadyExists(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);
        
        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId, FakeService::class, [])->willReturn($this->service);
        
        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->add($serviceType, $serviceId, FakeService::class, []);
        $container->add($serviceType, $serviceId, FakeService::class, []);
    }

    /**
     * Test wrong service identifier to get after creating standard or shared service
     *
     * @param ServiceType $serviceType
     *            Service type
     *            @dataProvider servicesTypesProvider
     *            @expectedException \Kocuj\Di\Container\NotFoundException
     */
    public function testAddWithWrongGet(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $wrongServiceId = 'OtherService';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($serviceId);
        $this->serviceIdDecorator->decorate($wrongServiceId)->willReturn($wrongServiceId);
        
        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $serviceId, FakeService::class, [])->willReturn($this->service);
        
        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->add($serviceType, $serviceId, FakeService::class, []);
        $container->get($wrongServiceId);
    }

    /**
     * Test calling wrong method
     *
     * @param ServiceType $serviceType
     *            Service type
     *            @dataProvider servicesTypesProvider
     *            @expectedException \PHPUnit\Framework\Error\Error
     */
    public function testWrongCallMethod(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);
        
        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId, FakeService::class, [])->willReturn($this->service);
        
        // act
        $container = new Container($this->serviceIdDecorator->reveal(), $this->serviceFactory->reveal());
        $container->wrongMethodSupportedByCall();
    }

    /**
     * Test calling with arguments
     *
     * @param ServiceType $serviceType
     *            Service type
     *            @dataProvider servicesTypesProvider
     *            @expectedException \Kocuj\Di\Container\ContainerException
     */
    public function testCallMethodWithArguments(ServiceType $serviceType)
    {
        // arrange
        $serviceId = 'Service';
        $decoratedServiceId = 'Service';
        $this->serviceIdDecorator->decorate($serviceId)->willReturn($decoratedServiceId);
        $this->serviceIdDecorator->decorate($decoratedServiceId)->willReturn($decoratedServiceId);
        
        $this->serviceFactory->create(Argument::type(ContainerInterface::class), $serviceType, $decoratedServiceId, FakeService::class, [])->willReturn($this->service);
        
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
