<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\DivisionBlockInterface;

/**
 * Class DivisionBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
final class DivisionBlock extends AbstractBlock implements DivisionBlockInterface
{

	/**
	 * @return string
	 */
	public function getBlockType()
	{
		return self::BLOCK_TYPE_DIVISION;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onDivisionBlock();
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
