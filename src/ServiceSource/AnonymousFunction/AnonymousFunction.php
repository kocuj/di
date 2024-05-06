<?php

/**
 * AnonymousFunction.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2020 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\AnonymousFunction;

use Closure;
use Kocuj\Di\ServiceSource\Exception;
use Kocuj\Di\ServiceSource\ServiceSourceInterface;

/**
 * Service source creator for anonymous function
 *
 * @package Kocuj\Di\ServiceSource\ClassName
 */
class AnonymousFunction implements ServiceSourceInterface
{
    /**
     * Service source
     *
     * @var mixed
     */
    private $serviceSource;

    /**
     * Constructor
     *
     * @param mixed $serviceSource Service source
     * @throws Exception
     */
    public function __construct($serviceSource)
    {
        // check if service source is a closure
        if (!is_object($serviceSource) || !($serviceSource instanceof Closure)) {
            throw new Exception('Service source is not an anonymous function');
        }
        // remember arguments
        $this->serviceSource = $serviceSource;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function resolve(): object
    {
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
