<?php

/**
 * AnonymousFunctionTest.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Tests\Unit\ServiceSource\AnonymousFunction;

use Kocuj\Di\Core\ServiceSource\AnonymousFunction\AnonymousFunction;
use Kocuj\Di\Core\ServiceSource\Exception;
use Kocuj\Di\Tests\Fixtures\FakeService;
use PHPUnit\Framework\TestCase;

/**
 * @package Kocuj\Di\Tests\ServiceSource\AnonymousFunction
 */
class AnonymousFunctionTest extends TestCase
{
    public function testWrongServiceSource(): void
    {
        // ---- ARRANGE ----

        $serviceSource = new FakeService();

        $this->expectException(Exception::class);

        // ---- ACT ----

        new AnonymousFunction($serviceSource);
    }

    public function testResolveWithoutObject(): void
    {
        // ---- ARRANGE ----

        $serviceSource = function () {
            return null;
        };

        $this->expectException(Exception::class);

        // ---- ACT ----

        $anonymousFunction = new AnonymousFunction($serviceSource);
        $anonymousFunction->resolve();
    }

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

        $this->assertSame($fakeService, $resolve);
    }
}
