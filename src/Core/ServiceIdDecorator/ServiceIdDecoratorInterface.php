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
 * Service identifier decorator interface
 *
 * @package Kocuj\Di\ServiceIdDecorator
 */
interface ServiceIdDecoratorInterface
{
    /**
     * Decorate identifier for service identifier
     *
     * @param string $id Identifier to decorate
     * @return string Decorated identifier
     */
    public function decorateForServiceId(string $id): string;

    /**
     * Decorate identifier for get service by get* method
     *
     * @param string $id Identifier to decorate
     * @return string Decorated identifier
     */
    public function decorateForGetMethod(string $id): string;
}
