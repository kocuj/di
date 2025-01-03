<?php

/*
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName;

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
