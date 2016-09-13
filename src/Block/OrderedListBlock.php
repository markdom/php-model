<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\OrderedListBlockInterface;

/**
 * Class OrderedListBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
final class OrderedListBlock extends AbstractBlock implements OrderedListBlockInterface
{

	use ListBlockTrait;

	/**
	 * @var int
	 */
	private $startIndex;

	/**
	 * OrderedListBlock constructor.
	 *
	 * @param int $startIndex
	 */
	public function __construct($startIndex)
	{
		$this->startIndex = $startIndex;
	}

	/**
	 * @return string
	 */
	public function getBlockType()
	{
		return BlockInterface::TYPE_ORDERED_LIST;
	}

	/**
	 * @return int
	 */
	public function getStartIndex()
	{
		return $this->startIndex;
	}

	/**
	 * @param int $startIndex
	 * @return $this
	 */
	public function setStartIndex($startIndex)
	{
		$this->startIndex = $startIndex;
		return $this;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onOrderedListBlockBegin($this->getStartIndex());
		for ($i = 0, $n = $this->getListItems()->size(); $i < $n; $i++) {
			$listItem = $this->getListItems()->get($i);
			$listItem->onHandle($markdomHandler);
			if (!$this->getListItems()->isLast($listItem)) {
				$markdomHandler->onNextListItem();
			}
		}
		$markdomHandler->onOrderedListBlockEnd($this->getStartIndex());
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
