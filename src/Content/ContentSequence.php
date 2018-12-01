<?php

namespace Markdom\Model\Content;

use Markdom\Model\Common\ListIterator;
use Markdom\Model\Exception\MarkdomModelException;
use Markdom\ModelInterface\Content\ContentInterface;
use Markdom\ModelInterface\Content\ContentParentInterface;
use Markdom\ModelInterface\Content\ContentSequenceInterface;
use Traversable;

/**
 * Class ContentSequence
 *
 * @package Markenwerk\Markdom\Model\Content
 */
final class ContentSequence implements ContentSequenceInterface
{

	/**
	 * @var ContentParentInterface
	 */
	private $parent;

	/**
	 * @var ContentInterface[]
	 */
	private $contents = array();

	/**
	 * ContentCollection constructor.
	 *
	 * @param ContentParentInterface $parent
	 */
	public function __construct(ContentParentInterface $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @return ContentParentInterface
	 */
	public function getParent(): ContentParentInterface
	{
		return $this->parent;
	}

	/**
	 * @return int
	 */
	public function size(): int
	{
		return count($this->contents);
	}

	/**
	 * @return bool
	 */
	public function isEmpty(): bool
	{
		return count($this->contents) === 0;
	}

	/**
	 * @param ContentInterface $content
	 * @return bool
	 */
	public function contains(ContentInterface $content): bool
	{
		$index = array_search($content, $this->contents, true);
		return $index !== false;
	}

	/**
	 * @param ContentInterface[] $contents
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function containsAll(array $contents): bool
	{
		foreach ($contents as $content) {
			if (!$contents instanceof ContentInterface) {
				$type = (is_object($content)) ? get_class($content) : gettype($content);
				throw new MarkdomModelException('Appending ' . $type . ' as content failed.');
			}
			$index = array_search($content, $this->contents, true);
			if ($index === false) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return ContentInterface
	 * @throws MarkdomModelException
	 */
	public function first(): ContentInterface
	{
		return $this->get(0);
	}

	/**
	 * @return ContentInterface
	 * @throws MarkdomModelException
	 */
	public function last(): ContentInterface
	{
		return $this->get($this->size() - 1);
	}

	/**
	 * @param int $index
	 * @return ContentInterface
	 * @throws MarkdomModelException
	 */
	public function get(int $index): ContentInterface
	{
		if (!array_key_exists($index, $this->contents)) {
			throw new MarkdomModelException('Content not found');
		}
		return $this->contents[$index];
	}

	/**
	 * @param ContentInterface $content
	 * @return int
	 * @throws MarkdomModelException
	 */
	public function indexOf(ContentInterface $content): int
	{
		$index = array_search($content, $this->contents, true);
		if ($index === false) {
			throw new MarkdomModelException('Content not found');
		}
		return $index;
	}

	/**
	 * @param ContentInterface $content
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function isFirst(ContentInterface $content): bool
	{
		return $this->indexOf($content) === 0;
	}

	/**
	 * @param ContentInterface $content
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function isLast(ContentInterface $content): bool
	{
		return $this->indexOf($content) === $this->size() - 1;
	}

	/**
	 * @param ContentInterface $content
	 * @return $this
	 */
	public function append(ContentInterface $content)
	{
		$this->contents[] = $content;
		$content->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param ContentInterface[] $contents
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function appendAll(array $contents)
	{
		foreach ($contents as $content) {
			if (!$contents instanceof ContentInterface) {
				$type = (is_object($content)) ? get_class($content) : gettype($content);
				throw new MarkdomModelException('Appending ' . $type . ' as content failed.');
			}
		}
		$this->contents = array_merge($this->contents, $contents);
		foreach ($contents as $content) {
			$content->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param ContentInterface $content
	 * @return $this
	 */
	public function prepend(ContentInterface $content)
	{
		array_unshift($this->contents, $content);
		$content->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param ContentInterface[] $contents
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function prependAll(array $contents)
	{
		foreach ($contents as $content) {
			if (!$contents instanceof ContentInterface) {
				$type = (is_object($content)) ? get_class($content) : gettype($content);
				throw new MarkdomModelException('Prepending ' . $type . ' as content failed.');
			}
		}
		$this->contents = array_merge($this->contents, $contents);
		foreach ($contents as $content) {
			$content->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param ContentInterface $content
	 * @param int $index
	 * @return $this
	 */
	public function insert(ContentInterface $content, int $index)
	{
		array_splice($this->contents, $index, 0, array($content));
		$content->onAttach($this->getParent());
		return $this;
	}

	/**
	 * @param ContentInterface[] $contents
	 * @param int $index
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAll(array $contents, int $index)
	{
		foreach ($contents as $content) {
			if (!$contents instanceof ContentInterface) {
				$type = (is_object($content)) ? get_class($content) : gettype($content);
				throw new MarkdomModelException('Inserting ' . $type . ' as content failed.');
			}
		}
		array_splice($this->contents, $index, 0, $contents);
		foreach ($contents as $content) {
			$content->onAttach($this->getParent());
		}
		return $this;
	}

	/**
	 * @param ContentInterface $content
	 * @param ContentInterface $referenceContent
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAfter(ContentInterface $content, ContentInterface $referenceContent)
	{
		$referenceIndex = $this->indexOf($referenceContent);
		return $this->insert($content, $referenceIndex + 1);
	}

	/**
	 * @param ContentInterface[] $contents
	 * @param ContentInterface $referenceContent
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAllAfter(array $contents, ContentInterface $referenceContent)
	{
		$referenceIndex = $this->indexOf($referenceContent);
		return $this->insertAll($contents, $referenceIndex + 1);
	}

	/**
	 * @param ContentInterface $content
	 * @param ContentInterface $referenceContent
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertBefore(ContentInterface $content, ContentInterface $referenceContent)
	{
		$referenceIndex = $this->indexOf($referenceContent);
		return $this->insert($content, $referenceIndex);
	}

	/**
	 * @param ContentInterface[] $contents
	 * @param ContentInterface $referenceContent
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function insertAllBefore(array $contents, ContentInterface $referenceContent)
	{
		$referenceIndex = $this->indexOf($referenceContent);
		return $this->insertAll($contents, $referenceIndex);
	}

	/**
	 * @param ContentInterface $content
	 * @param ContentInterface $replacedContent
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function replaceItem(ContentInterface $content, ContentInterface $replacedContent)
	{
		$index = $this->indexOf($replacedContent);
		if (is_null($index)) {
			$this->append($content);
		} else {
			$this->replace($content, $index);
		}
		return $this;
	}

	/**
	 * @param ContentInterface $content
	 * @param int $index
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function replace(ContentInterface $content, int $index)
	{
		$replacedBlock = $this->get($index);
		if (is_null($replacedBlock)) {
			$this->append($content);
		} else {
			array_splice($this->contents, $index, 1, array($content));
			$content->onAttach($this->getParent());
			$replacedBlock->onDetach();
		}
		return $this;
	}

	/**
	 * @return ContentInterface
	 */
	public function removeFirst(): ContentInterface
	{
		$removedBlock = array_shift($this->contents);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @return ContentInterface
	 */
	public function removeLast(): ContentInterface
	{
		$removedBlock = array_pop($this->contents);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @param ContentInterface[] $contents
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function removeAll(array $contents)
	{
		foreach ($contents as $content) {
			if (!$contents instanceof ContentInterface) {
				$type = (is_object($content)) ? get_class($content) : gettype($content);
				throw new MarkdomModelException('Removing ' . $type . ' from contents failed.');
			}
			$this->removeItem($content);
		}
		return $this;
	}

	/**
	 * @param ContentInterface $content
	 * @return ContentInterface
	 * @throws MarkdomModelException
	 */
	public function removeItem(ContentInterface $content): ContentInterface
	{
		$index = $this->indexOf($content);
		$this->remove($index);
		return $content;
	}

	/**
	 * @param int $index
	 * @return ContentInterface
	 * @throws MarkdomModelException
	 */
	public function remove(int $index): ContentInterface
	{
		$removedBlock = $this->get($index);
		if (is_null($removedBlock)) {
			throw new MarkdomModelException('Content not found');
		}
		array_splice($this->contents, $index, 1);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @return $this
	 */
	public function clear()
	{
		$this->contents = array();
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
		return new ListIterator($this->contents);
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
