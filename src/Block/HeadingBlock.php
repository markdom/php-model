<?php

declare(strict_types=1);

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\Model\Content\ContentParentTrait;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\HeadingBlockInterface;

/**
 * Class HeadingBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
class HeadingBlock extends AbstractBlock implements HeadingBlockInterface
{

	use ContentParentTrait;

	/**
	 * @var int
	 */
	private $level;

	/**
	 * HeadingBlock constructor.
	 *
	 * @param int $level
	 */
	public function __construct(int $level)
	{
		$this->level = $level;
	}

	/**
	 * @return int
	 */
	public function getLevel(): int
	{
		return $this->level;
	}

	/**
	 * @param int $level
	 * @return $this
	 */
	public function setLevel(int $level)
	{
		$this->level = $level;
		return $this;
	}

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
		return self::CONTENT_PARENT_TYPE_HEADING;
	}

	/**
	 * @return string
	 */
	public function getBlockType(): string
	{
		return self::BLOCK_TYPE_HEADING;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onHeadingBlockBegin($this->getLevel());
		$markdomHandler->onContentsBegin();
		for ($i = 0, $n = $this->getContents()->size(); $i < $n; $i++) {
			$content = $this->getContents()->get($i);
			$content->onHandle($markdomHandler);
			if (!$this->getContents()->isLast($content)) {
				$markdomHandler->onNextContent();
			}
		}
		$markdomHandler->onContentsEnd();
		$markdomHandler->onHeadingBlockEnd($this->getLevel());
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
