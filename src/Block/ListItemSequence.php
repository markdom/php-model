<?php

namespace Markdom\Model\Block;

use Markdom\Model\Common\ListIterator;
use Markdom\Model\Exception\MarkdomModelException;
use Markdom\ModelInterface\Block\ListBlockInterface;
use Markdom\ModelInterface\Block\ListItemInterface;
use Markdom\ModelInterface\Block\ListItemSequenceInterface;
use Traversable;

/**
 * Class ListItemSequence
 *
 * @package Markenwerk\Markdom\Model\Block
 */
final class ListItemSequence implements ListItemSequenceInterface
{

	/**
	 * @var ListBlockInterface
	 */
	private $parent;

	/**
	 * @var ListItemInterface[]
	 */
	private $items = array();

	/**
	 * ListItemCollection constructor.
	 *
	 * @param ListBlockInterface $parent
	 */
	public function __construct(ListBlockInterface $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @return ListBlockInterface
	 */
	public function getParent(): ListBlockInterface
	{
		return $this->parent;
	}

	/**
	 * @return int
	 */
	public function size(): int
	{
		return count($this->items);
	}

	/**
	 * @return bool
	 */
	public function isEmpty(): bool
	{
		return count($this->items) === 0;
	}

	/**
	 * @param ListItemInterface $item
	 * @return bool
	 */
	public function contains(ListItemInterface $item): bool
	{
		$index = array_search($item, $this->items, true);
		return $index !== false;
	}

	/**
	 * @param ListItemInterface[] $items
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function containsAll(array $items): bool
	{
		foreach ($items as $item) {
			if (!$items instanceof ListItemInterface) {
				$type = (is_object($item)) ? get_class($item) : gettype($item);
				throw new MarkdomModelException('Appending ' . $type . ' as list item failed.');
			}
			$index = array_search($item, $this->items, true);
			if ($index === false) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return ListItemInterface
	 * @throws MarkdomModelException
	 */
	public function first(): ListItemInterface
	{
		return $this->get(0);
	}

	/**
	 * @return ListItemInterface
	 * @throws MarkdomModelException
	 */
	public function last(): ListItemInterface
	{
		return $this->get($this->size() - 1);
	}

	/**
	 * @param int $index
	 * @return ListItemInterface
	 * @throws MarkdomModelException
	 */
	public function get(int $index): ListItemInterface
	{
		if (!array_key_exists($index, $this->items)) {
			throw new MarkdomModelException('List item not found');
		}
		return $this->items[$index];
	}

	/**
	 * @param ListItemInterface $item
	 * @return int
	 * @throws MarkdomModelException
	 */
	public function indexOf(ListItemInterface $item): int
	{
		$index = array_search($item, $this->items, true);
		if ($index === false) {
			throw new MarkdomModelException('list item not found');
		}
		return $index;
	}

	/**
	 * @param ListItemInterface $item
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function isFirst(ListItemInterface $item): bool
	{
		return $this->indexOf($item) === 0;
	}

	/**
	 * @param ListItemInterface $item
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function isLast(ListItemInterface $item): bool
	{
		return $this->indexOf($item) === $this->size() - 1;
	}

	/**
	 * @param ListItemInterface $item
	 * @return $this
	 */
	public function append(ListItemInterface $item)
	{
		$this->items[] = $item;
		$item->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param ListItemInterface[] $items
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function appendAll(array $items)
	{
		foreach ($items as $item) {
			if (!$items instanceof ListItemInterface) {
				$type = (is_object($item)) ? get_class($item) : gettype($item);
				throw new MarkdomModelException('Appending ' . $type . ' as list item failed.');
			}
		}
		$this->items = array_merge($this->items, $items);
		foreach ($items as $item) {
			$item->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param ListItemInterface $item
	 * @return $this
	 */
	public function prepend(ListItemInterface $item)
	{
		array_unshift($this->items, $item);
		$item->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param ListItemInterface[] $items
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function prependAll(array $items)
	{
		foreach ($items as $item) {
			if (!$items instanceof ListItemInterface) {
				$type = (is_object($item)) ? get_class($item) : gettype($item);
				throw new MarkdomModelException('Prepending ' . $type . ' as list item failed.');
			}
		}
		$this->items = array_merge($this->items, $items);
		foreach ($items as $item) {
			$item->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param ListItemInterface $item
	 * @param int $index
	 * @return $this
	 */
	public function insert(ListItemInterface $item, int $index)
	{
		array_splice($this->items, $index, 0, array($item));
		$item->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param ListItemInterface[] $items
	 * @param int $index
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAll(array $items, int $index)
	{
		foreach ($items as $item) {
			if (!$items instanceof ListItemInterface) {
				$type = (is_object($item)) ? get_class($item) : gettype($item);
				throw new MarkdomModelException('Inserting ' . $type . ' as list item failed.');
			}
		}
		array_splice($this->items, $index, 0, $items);
		foreach ($items as $item) {
			$item->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param ListItemInterface $item
	 * @param ListItemInterface $referenceItem
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAfter(ListItemInterface $item, ListItemInterface $referenceItem)
	{
		$referenceIndex = $this->indexOf($referenceItem);
		return $this->insert($item, $referenceIndex + 1);
	}

	/**
	 * @param ListItemInterface[] $items
	 * @param ListItemInterface $referenceItem
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAllAfter(array $items, ListItemInterface $referenceItem)
	{
		$referenceIndex = $this->indexOf($referenceItem);
		return $this->insertAll($items, $referenceIndex + 1);
	}

	/**
	 * @param ListItemInterface $item
	 * @param ListItemInterface $referenceItem
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertBefore(ListItemInterface $item, ListItemInterface $referenceItem)
	{
		$referenceIndex = $this->indexOf($referenceItem);
		return $this->insert($item, $referenceIndex);
	}

	/**
	 * @param ListItemInterface[] $items
	 * @param ListItemInterface $referenceItem
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAllBefore(array $items, ListItemInterface $referenceItem)
	{
		$referenceIndex = $this->indexOf($referenceItem);
		return $this->insertAll($items, $referenceIndex);
	}

	/**
	 * @param ListItemInterface $item
	 * @param ListItemInterface $replacedItem
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function replaceItem(ListItemInterface $item, ListItemInterface $replacedItem)
	{
		$index = $this->indexOf($replacedItem);
		if (is_null($index)) {
			$this->append($item);
		} else {
			$this->replace($item, $index);
		}
		return $this;
	}

	/**
	 * @param ListItemInterface $item
	 * @param int $index
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function replace(ListItemInterface $item, int $index)
	{
		$replacedBlock = $this->get($index);
		if (is_null($replacedBlock)) {
			$this->append($item);
		} else {
			array_splice($this->items, $index, 1, array($item));
			$item->onAttach($this->getParent());
			$replacedBlock->onDetach();
		}
		return $this;
	}

	/**
	 * @return ListItemInterface
	 */
	public function removeFirst(): ListItemInterface
	{
		$removedBlock = array_shift($this->items);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @return ListItemInterface
	 */
	public function removeLast(): ListItemInterface
	{
		$removedBlock = array_pop($this->items);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @param ListItemInterface[] $items
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function removeAll(array $items)
	{
		foreach ($items as $item) {
			if (!$items instanceof ListItemInterface) {
				$type = (is_object($item)) ? get_class($item) : gettype($item);
				throw new MarkdomModelException('Removing ' . $type . ' from list items failed.');
			}
			$this->removeItem($item);
		}
		return $this;
	}

	/**
	 * @param ListItemInterface $item
	 * @return ListItemInterface
	 * @throws MarkdomModelException
	 */
	public function removeItem(ListItemInterface $item): ListItemInterface
	{
		$index = $this->indexOf($item);
		$this->remove($index);
		return $item;
	}

	/**
	 * @param int $index
	 * @return ListItemInterface
	 * @throws MarkdomModelException
	 */
	public function remove(int $index): ListItemInterface
	{
		$removedBlock = $this->get($index);
		if (is_null($removedBlock)) {
			throw new MarkdomModelException('List item not found');
		}
		array_splice($this->items, $index, 1);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @return $this
	 */
	public function clear()
	{
		$this->items = array();
		return $this;
	}

	/**
	 * Retrieve an external iterator
	 *
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		return new ListIterator($this->items);
	}

	/**
	 * Count elements of an object
	 *
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int
	 */
	public function count(): int
	{
		return $this->size();
	}

}
