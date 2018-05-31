<?php

/**
 * Exception.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\Container;

use Psr\Container\ContainerExceptionInterface;

/**
 * Exception
 *
 * @package Kocuj\Di\Container
 */
class Exception extends /**
 * @scrutinizer ignore-deprecated
 */
    ContainerException implements ContainerExceptionInterface
{
}
