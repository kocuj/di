<?php

/*
 * ObjectInstanceTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Unit\ServiceSource\ObjectInstance;

use Kocuj\Di\Core\ServiceSource\Exception;
use Kocuj\Di\Core\ServiceSource\ObjectInstance\ObjectInstance;
use Kocuj\Di\Tests\Fixtures\FakeService;
use PHPUnit\Framework\TestCase;

/**
 * @package Kocuj\Di\Tests
 */
class ObjectInstanceTest extends TestCase
{
    public function testServiceSourceNoObject(): void
    {
        // ---- ARRANGE ----

        $serviceSource = 'test';

        $this->expectException(Exception::class);

        // ---- ACT ----

        new ObjectInstance($serviceSource);
    }

    public function testServiceSourceAnonymousFunction(): void
    {
        // ---- ARRANGE ----

        $serviceSource = function () {
            return null;
        };

        $this->expectException(Exception::class);

        // ---- ACT ----

        new ObjectInstance($serviceSource);
    }

    public function testResolve(): void
    {
        // ---- ARRANGE ----

        $fakeService = new FakeService();

        // ---- ACT ----

        $objectInstance = new ObjectInstance($fakeService);
        $resolve = $objectInstance->resolve();

        // ---- ASSERT ----

        $this->assertSame($fakeService, $resolve);
    }
}
