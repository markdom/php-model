<?php

declare(strict_types=1);

namespace Markdom\Model\Content;

use Markdom\Model\Common\AbstractNode;
use Markdom\Model\Common\EmptyCountableIterator;
use Markdom\Model\Exception\MarkdomModelException;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\DocumentInterface;
use Markdom\ModelInterface\Common\CountableIteratorInterface;
use Markdom\ModelInterface\Common\NodeInterface;
use Markdom\ModelInterface\Content\ContentInterface;
use Markdom\ModelInterface\Content\ContentParentInterface;

/**
 * Class AbstractContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
abstract class AbstractContent extends AbstractNode implements ContentInterface
{

	/**
	 * @var ContentParentInterface
	 */
	private $parent;

	/**
	 * @return string
	 */
	final public function getNodeType(): string
	{
		return NodeInterface::NODE_TYPE_CONTENT;
	}

	/**
	 * @return int
	 */
	final public function getIndex(): int
	{
		return $this->getParent()->getContents()->indexOf($this);
	}

	/**
	 * @return ContentParentInterface
	 */
	final public function getParent(): ContentParentInterface
	{
		return $this->parent;
	}

	/**
	 * @return bool
	 */
	final public function hasParent(): bool
	{
		return !is_null($this->getParent());
	}

	/**
	 * @return BlockInterface
	 */
	final public function getBlock(): BlockInterface
	{
		return $this->getParent()->getBlock();
	}

	/**
	 * @return DocumentInterface
	 */
	final public function getDocument(): DocumentInterface
	{
		return $this->getParent()->getDocument();
	}

	/**
	 * @return CountableIteratorInterface
	 */
	public function getChildren()
	{
		return new EmptyCountableIterator();
	}

	/**
	 * @param ContentParentInterface $contentParent
	 * @return $this
	 * @throws MarkdomModelException
	 */
	final public function onAttach(ContentParentInterface $contentParent)
	{
		if (!is_null($this->parent)) {
			throw new MarkdomModelException('Content is already attached');
		}
		$this->parent = $contentParent;
		return $this;
	}

	/**
	 * @return $this
	 * @throws MarkdomModelException
	 */
	final public function onDetach()
	{
		if (is_null($this->parent)) {
			throw new MarkdomModelException('Content is already detached');
		}
		$this->parent = null;
		return $this;
	}


}
