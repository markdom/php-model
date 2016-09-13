<?php

namespace Markdom\Model\Block;

use Markdom\Model\Common\AbstractNode;
use Markdom\Model\Common\EmptyCountableIterator;
use Markdom\Model\Exception\MarkdomModelException;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\BlockParentInterface;
use Markdom\ModelInterface\Block\DocumentInterface;
use Markdom\ModelInterface\Common\CountableIteratorInterface;
use Markdom\ModelInterface\Common\NodeInterface;

/**
 * Class AbstractBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
abstract class AbstractBlock extends AbstractNode implements BlockInterface
{

	/**
	 * @var BlockParentInterface
	 */
	private $parent;

	/**
	 * @return string
	 */
	final public function getNodeType()
	{
		return NodeInterface::NODE_TYPE_BLOCK;
	}

	/**
	 * @return int
	 */
	final public function getIndex()
	{
		return $this->getParent()->getBlocks()->indexOf($this);
	}

	/**
	 * @return BlockParentInterface
	 */
	final public function getParent()
	{
		return $this->parent;
	}

	/**
	 * @return bool
	 */
	final public function hasParent()
	{
		return !is_null($this->getParent());
	}

	/**
	 * @return DocumentInterface
	 */
	final public function getDocument()
	{
		return $this->getParent()->getDocument();
	}

	/**
	 * @return BlockInterface
	 */
	final public function getBlock()
	{
		return $this;
	}

	/**
	 * @return CountableIteratorInterface
	 */
	public function getChildren()
	{
		return new EmptyCountableIterator();
	}

	/**
	 * @param BlockParentInterface $blockParent
	 * @return $this
	 * @throws MarkdomModelException
	 */
	final public function onAttach(BlockParentInterface $blockParent)
	{
		if (!is_null($this->parent)) {
			throw new MarkdomModelException('Block is already attached');
		}
		$this->parent = $blockParent;
		return $this;
	}

	/**
	 * @return $this
	 * @throws MarkdomModelException
	 */
	final public function onDetach()
	{
		if (is_null($this->parent)) {
			throw new MarkdomModelException('Block is already detached');
		}
		$this->parent = null;
		return $this;
	}

}
