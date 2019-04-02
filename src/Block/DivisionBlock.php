<?php

declare(strict_types=1);

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\DivisionBlockInterface;

/**
 * Class DivisionBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
class DivisionBlock extends AbstractBlock implements DivisionBlockInterface
{

	/**
	 * @return string
	 */
	public function getBlockType(): string
	{
		return self::BLOCK_TYPE_DIVISION;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onDivisionBlock();
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
