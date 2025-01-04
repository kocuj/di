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
 * @package Kocuj\Di\ServiceSource
 */
interface ServiceSourceInterface
{
    /**
     * @param mixed $serviceSource
     */
    public function supports($serviceSource): bool;

    public function resolve(): object;
}
