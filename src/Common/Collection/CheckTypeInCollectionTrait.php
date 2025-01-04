<?php
/*
 * CheckTypeInCollectionTrait.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Common\Collection;

use ArrayObject;
use InvalidArgumentException;

/**
 * @package Kocuj\Di
 */
trait CheckTypeInCollectionTrait {
    protected ?string $requiredClass = null;

    private function checkElementsTypesInArray($array, string $exceptionText): void {
        if (
            !is_array($array)
            && !($array instanceof ArrayObject)
        ) {
            throw new Exception('Cannot set object for collection because it is not array of ArrayObject');
        }

        if (!is_null($this->requiredClass)) {
            foreach ($array as $val) {
                $this->checkTypeForElement($val, $exceptionText);
            }
        }
    }

    private function checkTypeForElement($value, string $exceptionText): void {
        if (!is_null($this->requiredClass)) {
            if (!($value instanceof $this->requiredClass)) {
                throw new Exception($exceptionText);
            }
        }
    }
}
