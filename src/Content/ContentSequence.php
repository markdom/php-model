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
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * @return int
	 */
	public function size()
	{
		return count($this->contents);
	}

	/**
	 * @return bool
	 */
	public function isEmpty()
	{
		return count($this->contents) === 0;
	}

	/**
	 * @param ContentInterface $content
	 * @return bool
	 */
	public function contains(ContentInterface $content)
	{
		$index = array_search($content, $this->contents, true);
		return $index !== false;
	}

	/**
	 * @param ContentInterface[] $contents
	 * @return bool
	 * @throws MarkdomModelException
	 */
	public function containsAll(array $contents)
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
	 */
	public function first()
	{
		return $this->get(0);
	}

	/**
	 * @return ContentInterface
	 */
	public function last()
	{
		return $this->get($this->size() - 1);
	}

	/**
	 * @param int $index
	 * @return ContentInterface
	 * @throws MarkdomModelException
	 */
	public function get($index)
	{
		if (!isset($this->contents[$index])) {
			throw new MarkdomModelException('Content not found');
		}
		return $this->contents[$index];
	}

	/**
	 * @param ContentInterface $content
	 * @return int
	 * @throws MarkdomModelException
	 */
	public function indexOf(ContentInterface $content)
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
	 */
	public function isFirst(ContentInterface $content)
	{
		return $this->indexOf($content) === 0;
	}

	/**
	 * @param ContentInterface $content
	 * @return bool
	 */
	public function isLast(ContentInterface $content)
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
	public function insert(ContentInterface $content, $index)
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
	public function insertAll(array $contents, $index)
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
	 */
	public function replace(ContentInterface $content, $index)
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
	public function removeFirst()
	{
		$removedBlock = array_shift($this->contents);
		$removedBlock->onDetach();
		return $removedBlock;
	}

	/**
	 * @return ContentInterface
	 */
	public function removeLast()
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
	public function removeItem(ContentInterface $content)
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
	public function remove($index)
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
	public function getIterator()
	{
		return new ListIterator($this->contents);
	}

	/**
	 * Count elements of an object
	 *
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int
	 */
	public function count()
	{
		return $this->size();
	}

}
