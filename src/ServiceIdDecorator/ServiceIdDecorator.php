<?php

/**
 * ServiceIdDecorator.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
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
     */
    private CamelizerInterface $camelizer;

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
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function decorateForServiceId(string $id): string
    {
        // exit
        return $this->camelizer->camelize($id);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function decorateForGetMethod(string $id): string
    {
        // exit
        return $this->camelizer->camelizeWithUpperFirstChar($id);
    }
}
