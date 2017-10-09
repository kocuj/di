<?php

/**
 * IArgumentParser.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\ArgumentParser;

use Kocuj\Di\Container\IContainer;

/**
 * Service argument parser
 */
interface IArgumentParser
{

    /**
     * Parse service argument and return argument to service constructor
     *
     * @param IContainer $container
     *            Dependency injection container for services
     * @param string $id
     *            Service identifier
     * @param array $argument
     *            Service argument to parse
     * @throws Exception
     * @return mixed Parsed argument
     */
    public function parse(IContainer $container, string $id, array $argument);
}
