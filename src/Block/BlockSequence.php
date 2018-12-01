<?php

namespace Markdom\Model\Block;

use Markdom\Model\Common\ListIterator;
use Markdom\Model\Exception\MarkdomModelException;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\BlockParentInterface;
use Markdom\ModelInterface\Block\BlockSequenceInterface;
use Traversable;

/**
 * Class BlockSequence
 *
 * @package Markenwerk\Markdom\Model\Block
 */
final class BlockSequence implements BlockSequenceInterface
{

	/**
	 * @var BlockParentInterface
	 */
	private $parent;

	/**
	 * @var BlockInterface[]
	 */
	private $blocks = array();

	/**
	 * BlockCollection constructor.
	 *
	 * @param BlockParentInterface $parent
	 */
	public function __construct(BlockParentInterface $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @return BlockParentInterface
	 */
	public function getParent(): BlockParentInterface
	{
		return $this->parent;
	}

	/**
	 * @return int
	 */
	public function size(): int
	{
		return count($this->blocks);
	}

	/**
	 * @return bool
	 */
	public function isEmpty(): bool
	{
		return count($this->blocks) === 0;
	}

	/**
	 * @param BlockInterface $block
	 * @return bool
	 */
	public function contains(BlockInterface $block): bool
	{
		$index = array_search($block, $this->blocks, true);
		return $index !== false;
	}

	/**
	 * @param BlockInterface[] $blocks
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function containsAll(array $blocks): bool
	{
		foreach ($blocks as $block) {
			if (!$blocks instanceof BlockInterface) {
				$type = (is_object($block)) ? get_class($block) : gettype($block);
				throw new MarkdomModelException('Appending ' . $type . ' as block failed.');
			}
			$index = array_search($block, $this->blocks, true);
			if ($index === false) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return BlockInterface
	 * @throws MarkdomModelException
	 */
	public function first(): BlockInterface
	{
		return $this->get(0);
	}

	/**
	 * @return BlockInterface
	 * @throws MarkdomModelException
	 */
	public function last(): BlockInterface
	{
		return $this->get($this->size() - 1);
	}

	/**
	 * @param int $index
	 * @return BlockInterface
	 * @throws MarkdomModelException
	 */
	public function get(int $index): BlockInterface
	{
		if (!array_key_exists($index, $this->blocks)) {
			throw new MarkdomModelException('Block not found');
		}
		return $this->blocks[$index];
	}

	/**
	 * @param BlockInterface $block
	 * @return int
	 * @throws MarkdomModelException
	 */
	public function indexOf(BlockInterface $block): int
	{
		$index = array_search($block, $this->blocks, true);
		if ($index === false) {
			throw new MarkdomModelException('Block not found');
		}
		return $index;
	}

	/**
	 * @param BlockInterface $block
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function isFirst(BlockInterface $block): bool
	{
		return $this->indexOf($block) === 0;
	}

	/**
	 * @param BlockInterface $block
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function isLast(BlockInterface $block): bool
	{
		return $this->indexOf($block) === $this->size() - 1;
	}

	/**
	 * @param BlockInterface $block
	 * @return $this
	 */
	public function append(BlockInterface $block)
	{
		$this->blocks[] = $block;
		$block->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param BlockInterface[] $blocks
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function appendAll(array $blocks)
	{
		foreach ($blocks as $block) {
			if (!$blocks instanceof BlockInterface) {
				$type = (is_object($block)) ? get_class($block) : gettype($block);
				throw new MarkdomModelException('Appending ' . $type . ' as block failed.');
			}
		}
		$this->blocks = array_merge($this->blocks, $blocks);
		foreach ($blocks as $block) {
			$block->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param BlockInterface $block
	 * @return $this
	 */
	public function prepend(BlockInterface $block)
	{
		array_unshift($this->blocks, $block);
		$block->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param BlockInterface[] $blocks
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function prependAll(array $blocks)
	{
		foreach ($blocks as $block) {
			if (!$blocks instanceof BlockInterface) {
				$type = (is_object($block)) ? get_class($block) : gettype($block);
				throw new MarkdomModelException('Prepending ' . $type . ' as block failed.');
			}
		}
		$this->blocks = array_merge($this->blocks, $blocks);
		foreach ($blocks as $block) {
			$block->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param BlockInterface $block
	 * @param int $index
	 * @return $this
	 */
	public function insert(BlockInterface $block, int $index)
	{
		array_splice($this->blocks, $index, 0, array($block));
		$block->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param BlockInterface[] $blocks
	 * @param int $index
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAll(array $blocks, int $index)
	{
		foreach ($blocks as $block) {
			if (!$blocks instanceof BlockInterface) {
				$type = (is_object($block)) ? get_class($block) : gettype($block);
				throw new MarkdomModelException('Inserting ' . $type . ' as block failed.');
			}
		}
		array_splice($this->blocks, $index, 0, $blocks);
		foreach ($blocks as $block) {
			$block->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param BlockInterface $block
	 * @param BlockInterface $referenceBlock
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAfter(BlockInterface $block, BlockInterface $referenceBlock)
	{
		$referenceIndex = $this->indexOf($referenceBlock);
		return $this->insert($block, $referenceIndex + 1);
	}

	/**
	 * @param BlockInterface[] $blocks
	 * @param BlockInterface $referenceBlock
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAllAfter(array $blocks, BlockInterface $referenceBlock)
	{
		$referenceIndex = $this->indexOf($referenceBlock);
		return $this->insertAll($blocks, $referenceIndex + 1);
	}

	/**
	 * @param BlockInterface $block
	 * @param BlockInterface $referenceBlock
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertBefore(BlockInterface $block, BlockInterface $referenceBlock)
	{
		$referenceIndex = $this->indexOf($referenceBlock);
		return $this->insert($block, $referenceIndex);
	}

	/**
	 * @param BlockInterface[] $blocks
	 * @param BlockInterface $referenceBlock
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAllBefore(array $blocks, BlockInterface $referenceBlock)
	{
		$referenceIndex = $this->indexOf($referenceBlock);
		return $this->insertAll($blocks, $referenceIndex);
	}

	/**
	 * @param BlockInterface $block
	 * @param BlockInterface $replacedBlock
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function replaceItem(BlockInterface $block, BlockInterface $replacedBlock)
	{
		$index = $this->indexOf($replacedBlock);
		if (is_null($index)) {
			$this->append($block);
		} else {
			$this->replace($block, $index);
		}
		return $this;
	}

	/**
	 * @param BlockInterface $block
	 * @param int $index
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function replace(BlockInterface $block, int $index)
	{
		$replacedBlock = $this->get($index);
		if (is_null($replacedBlock)) {
			$this->append($block);
		} else {
			array_splice($this->blocks, $index, 1, array($block));
			$block->onAttach($this->getParent());
			$replacedBlock->onDetach();
		}
		return $this;
	}

	/**
	 * @return BlockInterface
	 */
	public function removeFirst(): BlockInterface
	{
		$removedBlock = array_shift($this->blocks);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @return BlockInterface
	 */
	public function removeLast(): BlockInterface
	{
		$removedBlock = array_pop($this->blocks);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @param BlockInterface[] $blocks
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function removeAll(array $blocks)
	{
		foreach ($blocks as $block) {
			if (!$blocks instanceof BlockInterface) {
				$type = (is_object($block)) ? get_class($block) : gettype($block);
				throw new MarkdomModelException('Removing ' . $type . ' from blocks failed.');
			}
			$this->removeItem($block);
		}
		return $this;
	}

	/**
	 * @param BlockInterface $block
	 * @return BlockInterface
	 * @throws MarkdomModelException
	 */
	public function removeItem(BlockInterface $block): BlockInterface
	{
		$index = $this->indexOf($block);
		$this->remove($index);
		return $block;
	}

	/**
	 * @param int $index
	 * @return BlockInterface
	 * @throws MarkdomModelException
	 */
	public function remove(int $index): BlockInterface
	{
		$removedBlock = $this->get($index);
		if (is_null($removedBlock)) {
			throw new MarkdomModelException('Block not found');
		}
		array_splice($this->blocks, $index, 1);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @return $this
	 */
	public function clear()
	{
		$this->blocks = array();
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
		return new ListIterator($this->blocks);
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
