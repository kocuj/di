<?php

/*
 * ObjectInstance.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ObjectInstance;

use Closure;
use Kocuj\Di\Core\ServiceSource\Exception;
use Kocuj\Di\Core\ServiceSource\ServiceSourceInterface;

/**
 * Service source creator for object instance
 *
 * @package Kocuj\Di\ServiceSource\ObjectInstance
 */
class ObjectInstance implements ServiceSourceInterface
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
        return is_object($serviceSource) && !$serviceSource instanceof Closure;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(): object
    {
        if (!$this->supports($this->serviceSource)) {
            throw new Exception('Service source is not supported by this class');
        }

        // exit
        return $this->serviceSource;
    }
}
