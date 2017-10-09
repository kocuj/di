<?php

/**
 * ServiceIdDecorator.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\ServiceIdDecorator;

use Kocuj\Di\Tools\Camelizer\ICamelizer;

/**
 * Service identifier decorator
 */
class ServiceIdDecorator implements IServiceIdDecorator
{

    /**
     * Camelizer object
     *
     * @var ICamelizer
     */
    private $camelizer;

    /**
     * Constructor
     *
     * @param ICamelizer $camelizer
     *            Camelizer object
     *            @codeCoverageIgnore
     */
    public function __construct(ICamelizer $camelizer)
    {
        // remember arguments
        $this->camelizer = $camelizer;
    }

    /**
     * Decorate identifier
     *
     * @param string $id
     *            Identifier to decorate
     * @return string Decorated identifier
     * @see \Kocuj\Di\ServiceIdDecorator\IServiceIdDecorator::decorate() @codeCoverageIgnore
     */
    public function decorate(string $id): string
    {
        // exit
        return $this->camelizer->camelize($id);
    }
}
