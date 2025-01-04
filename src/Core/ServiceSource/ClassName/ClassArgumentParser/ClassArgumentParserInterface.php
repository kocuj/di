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
 * @package Kocuj\Di
 */
interface ClassArgumentParserInterface
{
    /**
     * @return mixed
     */
    public function parse();
}
