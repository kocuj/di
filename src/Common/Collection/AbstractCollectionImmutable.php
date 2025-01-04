<?php
/*
 * AbstractCollectionImmutable.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Common\Collection;

use ArrayIterator;
use ArrayObject;
use RuntimeException;

/**
 * @package Kocuj\Di
 */
abstract class AbstractCollectionImmutable extends ArrayObject implements CollectionImmutableInterface {
    use CheckTypeInCollectionTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct($array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class) {
        $this->checkElementsTypesInArray($array, 'Wrong type in array from which immutable collection should be created');

        parent::__construct($array, $flags, $iteratorClass);
    }

    public static function createFromCollection(CollectionInterface $collection): self {
        return new static($collection);
    }

    /**
     * {@inheritdoc}
     */
    public function append($value): void {
        throw new Exception('Method is not supported');
    }

    /**
     * {@inheritdoc}
     */
    public function exchangeArray($array): array {
        throw new Exception('Method is not supported');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void {
        throw new Exception('Method is not supported');
    }
}
