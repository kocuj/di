<?php

/*
 * ServiceFactory.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName;

/**
 * @package Kocuj\Di
 */
class ServiceFactory implements ServiceFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(string $className, array $arguments): object
    {
        return new $className(...$arguments);
    }
}
