<?php

/*
 * NotFoundException.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\Container;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Exception
 *
 * @package Kocuj\Di\Container
 */
class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
