<?php

/*
 * AnonymousFunction.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\AnonymousFunction;

use Closure;
use Kocuj\Di\Core\ServiceSource\Exception;
use Kocuj\Di\Core\ServiceSource\ServiceSourceInterface;

/**
 * @package Kocuj\Di
 */
class AnonymousFunction implements ServiceSourceInterface
{
    /**
     * @var mixed
     */
    private $serviceSource;

    /**
     * @param mixed $serviceSource Service source
     */
    public function __construct($serviceSource)
    {
        $this->serviceSource = $serviceSource;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($serviceSource): bool {
        return $serviceSource instanceof Closure;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function resolve(): object
    {
        if (!$this->supports($this->serviceSource)) {
            throw new Exception('Service source is not supported by this class');
        }

        $output = ($this->serviceSource)();

        if (!is_object($output)) {
            throw new Exception('An anonymous function has not returned an object');
        }

        return $output;
    }
}
