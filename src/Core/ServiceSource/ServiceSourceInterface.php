<?php

/*
 * ServiceSourceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource;

/**
 * Service source interface
 *
 * @package Kocuj\Di\ServiceSource
 */
interface ServiceSourceInterface
{
    public function supports($serviceSource): bool;

    /**
     * Resolve a service source into an object
     *
     * @return object Resolved service source
     */
    public function resolve(): object;
}
