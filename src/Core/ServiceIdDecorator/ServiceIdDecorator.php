<?php

/*
 * ServiceIdDecorator.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceIdDecorator;

use Kocuj\Di\Common\Camelizer\CamelizerInterface;

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
     */
    public function decorateForServiceId(string $id): string
    {
        // exit
        return $this->camelizer->camelize($id);
    }

    /**
     * {@inheritdoc}
     */
    public function decorateForGetMethod(string $id): string
    {
        // exit
        return $this->camelizer->camelizeWithUpperFirstChar($id);
    }
}
