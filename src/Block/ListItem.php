<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\Model\Common\AbstractNode;
use Markdom\Model\Exception\MarkdomModelException;
use Markdom\ModelInterface\Block\DocumentInterface;
use Markdom\ModelInterface\Block\ListBlockInterface;
use Markdom\ModelInterface\Block\ListItemInterface;
use Markdom\ModelInterface\Common\NodeInterface;

/**
 * Class ListItem
 *
 * @package Markenwerk\Markdom\Model\Block
 */
class ListItem extends AbstractNode implements ListItemInterface
{

	use BlockParentTrait;

	/**
	 * @var ListBlockInterface
	 */
	private $listBlock;

	/**
	 * @return string
	 */
	public function getBlockParentType()
	{
		return self::BLOCK_PARENT_TYPE_LIST_ITEM;
	}

	/**
	 * @return string
	 */
	public function getNodeType()
	{
		return NodeInterface::NODE_TYPE_LIST_ITEM;
	}

	/**
	 * @return int
	 */
	public function getIndex()
	{
		return $this->getParent()->getItems()->indexOf($this);
	}

	/**
	 * @return ListBlockInterface
	 */
	public function getParent()
	{
		return $this->listBlock;
	}

	/**
	 * @return bool
	 */
	public function hasParent()
	{
		return !is_null($this->getParent());
	}

	/**
	 * @return DocumentInterface
	 */
	public function getDocument()
	{
		return $this->getParent()->getDocument();
	}

	/**
	 * @param ListBlockInterface $listBlock
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function onAttach(ListBlockInterface $listBlock)
	{
		if (!is_null($this->listBlock)) {
			throw new MarkdomModelException('List item is already attached');
		}
		$this->listBlock = $listBlock;
		return $this;
	}

	/**
	 * @return $this
	 * @throws MarkdomModelException
	 */
	public function onDetach()
	{
		if (is_null($this->listBlock)) {
			throw new MarkdomModelException('list item is already detached');
		}
		$this->listBlock = null;
		return $this;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onListItemBegin();
		$markdomHandler->onBlocksBegin();
		for ($i = 0, $n = $this->getBlocks()->size(); $i < $n; $i++) {
			$block = $this->getBlocks()->get($i);
			$block->onHandle($markdomHandler);
			if (!$this->getBlocks()->isLast($block)) {
				$markdomHandler->onNextBlock();
			}
		}
		$markdomHandler->onBlocksEnd();
		$markdomHandler->onListItemEnd();
	}

}
