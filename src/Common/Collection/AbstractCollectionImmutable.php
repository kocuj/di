<?php

declare(strict_types=1);

namespace Kocuj\Di\Common\Collection;

use ArrayIterator;
use ArrayObject;
use RuntimeException;

abstract class AbstractCollectionImmutable extends ArrayObject implements CollectionImmutableInterface {
    use CheckTypeInCollectionTrait;

    public function __construct($array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class) {
        // TODO: check it $array is array or object !!!!
        // ...

        $this->checkElementsTypesInArray($array, 'Wrong type in array from which immutable collection should be created');

        parent::__construct($array, $flags, $iteratorClass);
    }

    public static function createFromCollection(CollectionInterface $collection): self {
        return new static($collection);
    }

    public function append($value): void {
        throw new Exception('Method is not supported');
    }

    public function exchangeArray($array): array {
        // TODO: check it $array is array or object !!!!
        // ...

        throw new Exception('Method is not supported');
    }

    public function offsetSet($offset, $value): void {
        throw new Exception('Method is not supported');
    }
}
