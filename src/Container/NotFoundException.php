<?php

/**
 * NotFoundException.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\Container;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Exception
 *
 * @package Kocuj\Di\Container
 */
class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
