<?php

declare(strict_types=1);

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\OrderedListBlockInterface;

/**
 * Class OrderedListBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
class OrderedListBlock extends AbstractBlock implements OrderedListBlockInterface
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
	public function __construct(int $startIndex)
	{
		$this->startIndex = $startIndex;
	}

	/**
	 * @return string
	 */
	public function getListBlockType(): string
	{
		return self::LIST_BLOCK_TYPE_ORDERED_LIST;
	}

	/**
	 * @return string
	 */
	public function getBlockType(): string
	{
		return self::BLOCK_TYPE_ORDERED_LIST;
	}

	/**
	 * @return int
	 */
	public function getStartIndex(): int
	{
		return $this->startIndex;
	}

	/**
	 * @param int $startIndex
	 * @return $this
	 */
	public function setStartIndex(int $startIndex)
	{
		$this->startIndex = $startIndex;
		return $this;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onOrderedListBlockBegin($this->getStartIndex());
		for ($i = 0, $n = $this->getItems()->size(); $i < $n; $i++) {
			$listItem = $this->getItems()->get($i);
			$listItem->onHandle($markdomHandler);
			if (!$this->getItems()->isLast($listItem)) {
				$markdomHandler->onNextListItem();
			}
		}
		$markdomHandler->onOrderedListBlockEnd($this->getStartIndex());
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
