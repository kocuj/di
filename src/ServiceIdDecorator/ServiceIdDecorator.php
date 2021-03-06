<?php

/**
 * ServiceIdDecorator.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2018 kocuj.pl
 */

namespace Kocuj\Di\ServiceIdDecorator;

use Kocuj\Di\Tools\Camelizer\CamelizerInterface;

/**
 * Service identifier decorator
 *
 * @package Kocuj\Di\ServiceIdDecorator
 */
class ServiceIdDecorator implements ServiceIdDecoratorInterface
{
    /**
     * Camelizer object
     *
     * @var CamelizerInterface
     */
    private $camelizer;

    /**
     * Constructor
     *
     * @param CamelizerInterface $camelizer Camelizer object
     * @codeCoverageIgnore
     */
    public function __construct(CamelizerInterface $camelizer)
    {
        // remember arguments
        $this->camelizer = $camelizer;
    }

    /**
     * Decorate identifier
     *
     * @param string $id Identifier to decorate
     * @return string Decorated identifier
     * @see \Kocuj\Di\ServiceIdDecorator\ServiceIdDecoratorInterface::decorate()
     * @codeCoverageIgnore
     */
    public function decorate(string $id): string
    {
        // set decorated identifier
        $decoratedId = $this->camelizer->camelize($id);
        // exit
        return $decoratedId;
    }
}
