<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\QuoteBlockInterface;

/**
 * Class QuoteBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
class QuoteBlock extends AbstractBlock implements QuoteBlockInterface
{

	use BlockParentTrait;

	/**
	 * @return string
	 */
	public function getBlockParentType()
	{
		return self::BLOCK_PARENT_TYPE_QUOTE;
	}

	/**
	 * @return string
	 */
	public function getBlockType()
	{
		return self::BLOCK_TYPE_QUOTE;
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
