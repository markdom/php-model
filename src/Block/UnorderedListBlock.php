<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\UnorderedListBlockInterface;

/**
 * Class UnorderedListBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
final class UnorderedListBlock extends AbstractBlock implements UnorderedListBlockInterface
{

	use ListBlockTrait;

	/**
	 * @return string
	 */
	final public function getBlockType()
	{
		return BlockInterface::TYPE_UNORDERED_LIST;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onUnorderedListBlockBegin();
		for ($i = 0, $n = $this->getListItems()->size(); $i < $n; $i++) {
			$listItem = $this->getListItems()->get($i);
			$listItem->onHandle($markdomHandler);
			if (!$this->getListItems()->isLast($listItem)) {
				$markdomHandler->onNextListItem();
			}
		}
		$markdomHandler->onUnorderedListBlockEnd();
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
