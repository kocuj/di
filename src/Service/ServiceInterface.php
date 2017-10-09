<?php

/**
 * ServiceInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017 kocuj.pl
 * @package kocuj_di
 */
namespace Kocuj\Di\Service;

/**
 * Service creator interface
 */
interface ServiceInterface
{

    /**
     * Get service
     *
     * @return object Service object
     */
    public function getService();
}
