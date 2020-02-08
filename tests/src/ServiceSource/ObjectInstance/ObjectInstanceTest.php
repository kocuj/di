<?php

/**
 * ObjectInstanceTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Tests\ServiceSource\ObjectInstance;

use Kocuj\Di\ServiceSource\Exception;
use Kocuj\Di\ServiceSource\ObjectInstance\ObjectInstance;
use Kocuj\Di\TestsLib\FakeService;
use PHPUnit\Framework\TestCase;

/**
 * Tests for ObjectInstance object
 *
 * @package Kocuj\Di\Tests\ServiceSource\ObjectInstance
 */
class ObjectInstanceTest extends TestCase
{
    /**
     * Testing service source when it is not an object
     *
     * @throws Exception
     * @expectedException Exception
     */
    public function testServiceSourceNoObject(): void
    {
        // ---- ARRANGE ----

        $serviceSource = 'test';

        // ---- ACT ----

        new ObjectInstance($serviceSource);
    }

    /**
     * Testing service source when it is an anonymous function
     *
     * @throws Exception
     * @expectedException Exception
     */
    public function testServiceSourceAnonymousFunction(): void
    {
        // ---- ARRANGE ----

        $serviceSource = function () {
            return null;
        };

        // ---- ACT ----

        new ObjectInstance($serviceSource);
    }

    /**
     * Testing resolving service
     *
     * @throws Exception
     */
    public function testResolve(): void
    {
        // ---- ARRANGE ----

        $fakeService = new FakeService();

        // ---- ACT ----

        $objectInstance = new ObjectInstance($fakeService);
        $resolve = $objectInstance->resolve();

        // ---- ASSERT ----

        // check if output service is based on input service identifier
        $this->assertSame($fakeService, $resolve);
    }
}
