<?php

/*
 * ServiceFactoryInterface.php
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
interface ServiceFactoryInterface
{
    public function create(string $className, array $arguments): object;
}
