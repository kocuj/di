<?php

/*
 * ArgumentParserInterface.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2024 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Core\ServiceSource\ClassName\ClassArgumentParser;

/**
 * Service argument parser interface
 *
 * @package Kocuj\Di\ServiceSource\ClassName\ArgumentParser
 */
interface ClassArgumentParserInterface
{
    /**
     * @return mixed
     */
    public function parse();
}
