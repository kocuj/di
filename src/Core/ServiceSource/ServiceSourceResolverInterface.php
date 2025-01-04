<?php

/*
 * ServiceSourceResolverInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource;

use Kocuj\Di\Core\Container\ContainerInterface;

interface ServiceSourceResolverInterface
{
    /**
     * @param mixed $serviceSource
     */
    public function resolve(ContainerInterface $container, string $id, $serviceSource): object;
}
