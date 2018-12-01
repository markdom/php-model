<?php

namespace Markdom\Model\Block;

use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\BlockSequenceInterface;

/**
 * Class BlockParentTrait
 *
 * @package Markenwerk\Markdom\Model\Block
 */
trait BlockParentTrait
{

	/**
	 * @var BlockSequenceInterface
	 */
	private $blocks;

	/**
	 * @return BlockSequenceInterface
	 */
	final public function getBlocks(): BlockSequenceInterface
	{
		if (is_null($this->blocks)) {
			/** @noinspection PhpParamsInspection */
			$this->blocks = new BlockSequence($this);
		}
		return $this->blocks;
	}

	/**
	 * @return BlockSequenceInterface
	 */
	final public function getChildren(): BlockSequenceInterface
	{
		return $this->getBlocks();
	}

	/**
	 * @param BlockInterface $block
	 * @return $this
	 */
	final public function addBlock(BlockInterface $block)
	{
		$this->getBlocks()->append($block);
		return $this;
	}

	/**
	 * @param BlockInterface[] $blocks
	 * @return $this
	 */
	final public function addBlocks(array $blocks)
	{
		foreach ($blocks as $block) {
			$this->getBlocks()->append($block);
		}
		return $this;
	}

}
