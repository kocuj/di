<?php

declare(strict_types=1);

namespace Kocuj\Di\Common\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Serializable;

interface CollectionInterface extends IteratorAggregate, ArrayAccess, Serializable, Countable {
}
