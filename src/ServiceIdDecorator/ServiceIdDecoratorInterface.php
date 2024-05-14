<?php

/**
 * ServiceIdDecoratorInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\ServiceIdDecorator;

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
