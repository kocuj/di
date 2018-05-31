<?php

/**
 * ServiceIdDecoratorInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
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
     * Decorate identifier
     *
     * @param string $id Identifier to decorate
     * @return string Decorated identifier
     */
    public function decorate(string $id): string;
}
