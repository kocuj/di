<?php

/*
 * ServiceIdDecorator.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceIdDecorator;

use Kocuj\Di\Common\Camelizer\CamelizerInterface;

/**
 * @package Kocuj\Di
 */
class ServiceIdDecorator implements ServiceIdDecoratorInterface
{
    private CamelizerInterface $camelizer;

    public function __construct(CamelizerInterface $camelizer)
    {
        $this->camelizer = $camelizer;
    }

    /**
     * {@inheritdoc}
     */
    public function decorateForServiceId(string $id): string
    {
        return $this->camelizer->camelize($id);
    }

    /**
     * {@inheritdoc}
     */
    public function decorateForGetMethod(string $id): string
    {
        return $this->camelizer->camelizeWithUpperFirstChar($id);
    }
}
