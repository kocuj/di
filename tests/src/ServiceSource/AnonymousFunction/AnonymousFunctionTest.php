<?php

/**
 * AnonymousFunctionTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\Tests\ServiceSource\AnonymousFunction;

use Kocuj\Di\ServiceSource\AnonymousFunction\AnonymousFunction;
use Kocuj\Di\ServiceSource\Exception;
use Kocuj\Di\TestsLib\FakeService;
use PHPUnit\Framework\TestCase;

/**
 * Tests for AnonymousFunction object
 *
 * @package Kocuj\Di\Tests\ServiceSource\AnonymousFunction
 */
class AnonymousFunctionTest extends TestCase
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

        $serviceSource = new FakeService();

        // ---- ACT ----

        new AnonymousFunction($serviceSource);
    }

    /**
     * Testing resolving service without returning an object
     *
     * @throws Exception
     * @expectedException Exception
     */
    public function testResolveWithoutObject(): void
    {
        // ---- ARRANGE ----

        $serviceSource = function () {
            return null;
        };

        // ---- ACT ----

        $anonymousFunction = new AnonymousFunction($serviceSource);
        $anonymousFunction->resolve();
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

        $serviceSource = function () use ($fakeService) {
            return $fakeService;
        };

        // ---- ACT ----

        $anonymousFunction = new AnonymousFunction($serviceSource);
        $resolve = $anonymousFunction->resolve();

        // ---- ASSERT ----

        // check if output service is based on input service identifier
        $this->assertSame($fakeService, $resolve);
    }
}
