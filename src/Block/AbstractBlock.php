<?php

declare(strict_types=1);

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
	final public function getNodeType(): string
	{
		return NodeInterface::NODE_TYPE_BLOCK;
	}

	/**
	 * @return int
	 */
	final public function getIndex(): int
	{
		return $this->getParent()->getBlocks()->indexOf($this);
	}

	/**
	 * @return BlockParentInterface
	 */
	final public function getParent(): BlockParentInterface
	{
		return $this->parent;
	}

	/**
	 * @return bool
	 */
	final public function hasParent(): bool
	{
		return $this->getParent() !== null;
	}

	/**
	 * @return DocumentInterface
	 */
	final public function getDocument(): DocumentInterface
	{
		$parent = $this->getParent();
		return $parent->getDocument();
	}

	/**
	 * @noinspection ReturnTypeCanBeDeclaredInspection
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
