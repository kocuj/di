<?php

declare(strict_types=1);

namespace Kocuj\Di\Common\Collection;

use ArrayObject;
use InvalidArgumentException;

trait CheckTypeInCollectionTrait {
    protected ?string $requiredClass = null;

    private function checkElementsTypesInArray($array, string $exceptionText): void {
        // TODO: check it $array is array or object !!!!
        // ...

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
