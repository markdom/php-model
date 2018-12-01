<?php

namespace Markdom\Model\Common;

use Markdom\ModelInterface\Common\CountableIteratorInterface;
use Traversable;

/**
 * Class EmptyCountableIterator
 *
 * @package Markenwerk\Markdom\Model\Common
 */
final class EmptyCountableIterator implements CountableIteratorInterface
{

	/**
	 * Retrieve an external iterator
	 *
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		return new ListIterator(array());
	}

	/**
	 * @return bool
	 */
	public function isEmpty(): bool
	{
		return true;
	}

	/**
	 * Count elements of an object
	 *
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int
	 */
	public function count(): int
	{
		return 0;
	}

}
