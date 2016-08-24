<?php

namespace Markdom\Model\Common;

/**
 * Class ListIterator
 *
 * @package Markenwerk\Markdom\Model\Common
 */
class ListIterator implements \Iterator
{

	/**
	 * @var int
	 */
	private $cursor = 0;

	/**
	 * @var array
	 */
	private $collection;

	/**
	 * CollectionIterator constructor.
	 *
	 * @param array $collection
	 */
	public function __construct(array $collection)
	{
		$this->collection = $collection;
	}

	/**
	 * Return the current element
	 *
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed
	 */
	public function current()
	{
		return $this->collection[$this->cursor];
	}

	/**
	 * Move forward to next element
	 *
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void
	 */
	public function next()
	{
		$this->cursor++;
	}

	/**
	 * Return the key of the current element
	 *
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return int
	 */
	public function key()
	{
		return $this->cursor;
	}

	/**
	 * Checks if current position is valid
	 *
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return bool
	 */
	public function valid()
	{
		return isset($this->collection[$this->cursor]);
	}

	/**
	 * Rewind the Iterator to the first element
	 *
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void
	 */
	public function rewind()
	{
		$this->cursor = 0;
	}

}
