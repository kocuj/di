<?php

/**
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ClassName;

/**
 * Service factory
 *
 * @package Kocuj\Di\ServiceSource\ClassName
 */
class ServiceFactory implements ServiceFactoryInterface
{
    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function create(string $className, array $arguments): object
    {
        // exit
        return new $className(...$arguments);
    }
}
