<?php

/**
 * ContainerException.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\Container;

use Psr\Container\ContainerExceptionInterface;

/**
 * Exception - for compatibility with 1.2.0
 *
 * @package Kocuj\Di\Container
 * @deprecated
 */
class ContainerException extends \Exception implements ContainerExceptionInterface
{
}
