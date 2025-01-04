<?php

/*
 * ServiceIdDecoratorInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceIdDecorator;

/**
 * @package Kocuj\Di\ServiceIdDecorator
 */
interface ServiceIdDecoratorInterface
{
    public function decorateForServiceId(string $id): string;

    public function decorateForGetMethod(string $id): string;
}
