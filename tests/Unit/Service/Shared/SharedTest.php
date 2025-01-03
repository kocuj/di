<?php

/**
 * SharedTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Unit\Service\Shared;

use Kocuj\Di\Core\Container\ContainerInterface;
use Kocuj\Di\Core\Service\Shared\Shared;
use Kocuj\Di\Core\ServiceSource\ServiceSourceFactoryInterface;
use Kocuj\Di\Core\ServiceSource\ServiceSourceInterface;
use Kocuj\Di\Tests\Fixtures\FakeService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;

/**
 * Tests for Shared object
 *
 * @package Kocuj\Di\Tests\Service\Shared
 */
class SharedTest extends TestCase
{
    /**
     * Testing get the selected service
     *
     */
    public function testGetService(): void
    {
        // ---- ARRANGE ----

        $id = 'ThisService';

        $serviceSourceFactory = $this->prophesize(ServiceSourceFactoryInterface::class);

        $container = $this->prophesize(ContainerInterface::class);

        $fakeService = new FakeService();

        /** @var ServiceSourceFactoryInterface $serviceSourceFactoryReveal */
        $serviceSourceFactoryReveal = $serviceSourceFactory->reveal();

        /** @var ContainerInterface $containerReveal */
        $containerReveal = $container->reveal();

        $serviceSource = $this->prophesize(ServiceSourceInterface::class);

        /** @var ServiceSourceInterface $serviceSourceReveal */
        $serviceSourceReveal = $serviceSource->reveal();

        /** @var ServiceSourceInterface $serviceSource */

        /** @var MethodProphecy $serviceSourceResolve */
        $serviceSourceResolve = $serviceSource->resolve();
        $serviceSourceResolve->willReturn($fakeService);

        /** @var ServiceSourceFactoryInterface $serviceSourceFactory */
        $serviceSourceFactoryCreate = $serviceSourceFactory->create($containerReveal, $id, $fakeService);
        /** @var MethodProphecy $serviceSourceFactoryCreate */
        $serviceSourceFactoryCreate->willReturn($serviceSourceReveal);

        // ---- ACT ----

        $shared = new Shared($serviceSourceFactoryReveal, $containerReveal, $id, $fakeService);

        $returnedService = $shared->getService();
        $returnedService2 = $shared->getService();

        // ---- ASSERT ----

        // check if service is the same
        $this->assertSame($returnedService, $fakeService);
        // check if service is the same when second time it will be get
        $this->assertSame($returnedService2, $fakeService);
    }
}
