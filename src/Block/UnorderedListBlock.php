<?php

declare(strict_types=1);

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\UnorderedListBlockInterface;

/**
 * Class UnorderedListBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
class UnorderedListBlock extends AbstractBlock implements UnorderedListBlockInterface
{

	use ListBlockTrait;

	/**
	 * @return string
	 */
	public function getListBlockType(): string
	{
		return self::LIST_BLOCK_TYPE_UNORDERED_LIST;
	}

	/**
	 * @return string
	 */
	public function getBlockType(): string
	{
		return self::BLOCK_TYPE_UNORDERED_LIST;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onUnorderedListBlockBegin();
		for ($i = 0, $n = $this->getItems()->size(); $i < $n; $i++) {
			$listItem = $this->getItems()->get($i);
			$listItem->onHandle($markdomHandler);
			if (!$this->getItems()->isLast($listItem)) {
				$markdomHandler->onNextListItem();
			}
		}
		$markdomHandler->onUnorderedListBlockEnd();
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
