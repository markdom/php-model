<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\BlockInterface;
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
	final public function getBlockType()
	{
		return BlockInterface::TYPE_DIVISION;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	final public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onDivisionBlock();
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
