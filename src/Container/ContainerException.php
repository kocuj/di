<?php

/**
 * ContainerException.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Container;

use Psr\Container\ContainerExceptionInterface;

/**
 * Exception
 */
class ContainerException extends \Exception implements ContainerExceptionInterface
{
}
