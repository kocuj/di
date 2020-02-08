<?php

/**
 * ObjectInstance.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2019 kocuj.pl
 */

namespace Kocuj\Di\ServiceSource\ObjectInstance;

use Closure;
use Kocuj\Di\ServiceSource\Exception;
use Kocuj\Di\ServiceSource\ServiceSourceInterface;

/**
 * Service source creator for object instance
 *
 * @package Kocuj\Di\ServiceSource\ObjectInstance
 */
class ObjectInstance implements ServiceSourceInterface
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
        // check if service source is an object
        if (!is_object($serviceSource)) {
            throw new Exception('Service source is not an object');
        }
        if ($serviceSource instanceof Closure) {
            throw new Exception('Service source is an anonymous function when object is required');
        }
        // remember arguments
        $this->serviceSource = $serviceSource;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve()
    {
        // exit
        return $this->serviceSource;
    }
}
