<?php

declare(strict_types=1);

namespace Kocuj\Di\Common\Collection;

use ArrayIterator;
use ArrayObject;

abstract class AbstractCollection extends ArrayObject implements CollectionInterface {
    use CheckTypeInCollectionTrait;

    public function __construct($array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class) {
        // TODO: check it $array is array or object !!!!
        // ...

        $this->checkElementsTypesInArray($array, 'Wrong type in array from which collection should be created');

        parent::__construct($array, $flags, $iteratorClass);
    }

    public static function createFromCollectionImmutable(CollectionImmutableInterface $collectionImmutable): self {
        return new static($collectionImmutable);
    }

    public function append($value): void {
        $this->checkTypeForElement($value, 'Wrong type for append to collection');

        parent::append($value);
    }

    public function exchangeArray($array): array {
        // TODO: check it $array is array or object !!!!
        // ...

        $this->checkElementsTypesInArray($array, 'Wrong type in array for which collection tried to exchange');

        return parent::exchangeArray($array);
    }

    public function offsetSet($offset, $value): void {
        $this->checkTypeForElement($value, 'Wrong type for set in collection');

        parent::offsetSet($offset, $value);
    }
}
