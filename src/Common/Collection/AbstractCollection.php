<?php
/*
 * AbstractCollection.php
 *
 * @author Dominik Kocuj
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2017-2025 kocuj.pl
 */

declare(strict_types=1);

namespace Kocuj\Di\Common\Collection;

use ArrayIterator;
use ArrayObject;

/**
 * @package Kocuj\Di
 */
abstract class AbstractCollection extends ArrayObject implements CollectionInterface {
    use CheckTypeInCollectionTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct($array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class) {
        $this->checkElementsTypesInArray($array, 'Wrong type in array from which collection should be created');

        parent::__construct($array, $flags, $iteratorClass);
    }

    public static function createFromCollectionImmutable(CollectionImmutableInterface $collectionImmutable): self {
        return new static($collectionImmutable);
    }

    /**
     * {@inheritdoc}
     */
    public function append($value): void {
        $this->checkTypeForElement($value, 'Wrong type for append to collection');

        parent::append($value);
    }

    /**
     * {@inheritdoc}
     */
    public function exchangeArray($array): array {
        $this->checkElementsTypesInArray($array, 'Wrong type in array for which collection tried to exchange');

        return parent::exchangeArray($array);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void {
        $this->checkTypeForElement($value, 'Wrong type for set in collection');

        parent::offsetSet($offset, $value);
    }
}
