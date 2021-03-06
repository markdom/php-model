<?php

declare(strict_types=1);

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\Model\Content\ContentParentTrait;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\ParagraphBlockInterface;

/**
 * Class ParagraphBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
class ParagraphBlock extends AbstractBlock implements ParagraphBlockInterface
{

	use ContentParentTrait;

	/**
	 * @return BlockInterface
	 */
	public function getBlock(): BlockInterface
	{
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentParentType(): string
	{
		return self::CONTENT_PARENT_TYPE_PARAGRAPH;
	}

	/**
	 * @return string
	 */
	public function getBlockType(): string
	{
		return self::BLOCK_TYPE_PARAGRAPH;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onParagraphBlockBegin();
		$markdomHandler->onContentsBegin();
		for ($i = 0, $n = $this->getContents()->size(); $i < $n; $i++) {
			$content = $this->getContents()->get($i);
			$content->onHandle($markdomHandler);
			if (!$this->getContents()->isLast($content)) {
				$markdomHandler->onNextContent();
			}
		}
		$markdomHandler->onContentsEnd();
		$markdomHandler->onParagraphBlockEnd();
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
