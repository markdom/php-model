<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\QuoteBlockInterface;

/**
 * Class QuoteBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
final class QuoteBlock extends AbstractBlock implements QuoteBlockInterface
{

	use BlockParentTrait;

	/**
	 * @return string
	 */
	public function getBlockType()
	{
		return BlockInterface::TYPE_QUOTE;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onQuoteBlockBegin();
		$markdomHandler->onBlocksBegin();
		for ($i = 0, $n = $this->getBlocks()->size(); $i < $n; $i++) {
			$block = $this->getBlocks()->get($i);
			$block->onHandle($markdomHandler);
			if (!$this->getBlocks()->isLast($block)) {
				$markdomHandler->onNextBlock();
			}
		}
		$markdomHandler->onBlocksEnd();
		$markdomHandler->onQuoteBlockEnd();
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
