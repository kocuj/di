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
 * Service source creator for anonymous function
 *
 * @package Kocuj\Di\ServiceSource\ClassName
 */
class AnonymousFunction implements ServiceSourceInterface
{
    private $serviceSource;

    /**
     * Constructor
     *
     * @param mixed $serviceSource Service source
     * @throws Exception
     */
    public function __construct($serviceSource)
    {
        // remember arguments
        $this->serviceSource = $serviceSource;
    }

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

        // call anonymous function
        $output = ($this->serviceSource)();
        // check if anonymous function has returned an object
        if (!is_object($output)) {
            throw new Exception('An anonymous function has not returned an object');
        }
        // exit
        return $output;
    }
}
