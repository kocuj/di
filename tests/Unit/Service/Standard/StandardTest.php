<?php

/**
 * StandardTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Tests\Unit\Service\Standard;

use Kocuj\Di\Container\ContainerInterface;
use Kocuj\Di\Service\Standard\Standard;
use Kocuj\Di\ServiceSource\ServiceSourceFactoryInterface;
use Kocuj\Di\ServiceSource\ServiceSourceInterface;
use Kocuj\Di\Tests\Fixtures\FakeService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;

/**
 * Tests for Standard object
 *
 * @package Kocuj\Di\Tests\Service\Standard
 */
class StandardTest extends TestCase
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

        $standard = new Standard($serviceSourceFactoryReveal, $containerReveal, $id, $fakeService);

        $returnedService = $standard->getService();

        // ---- ASSERT ----

        // check if service is the same
        $this->assertSame($returnedService, $fakeService);
    }
}
