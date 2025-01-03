<?php

/*
 * ServiceFactoryInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName;

/**
 * Service factory interface
 *
 * @package Kocuj\Di\ServiceSource\ClassName
 */
interface ServiceFactoryInterface
{
    /**
     * Create service
     *
     * @param string $className Class name
     * @param array $arguments Arguments
     * @return object Created service object
     */
    public function create(string $className, array $arguments): object;
}
