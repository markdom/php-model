<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\Model\Common\AbstractNode;
use Markdom\ModelInterface\Block\DocumentInterface;
use Markdom\ModelInterface\Common\NodeInterface;

/**
 * Class Document
 *
 * @package Markenwerk\Markdom\Model
 */
final class Document extends AbstractNode implements DocumentInterface
{

	use BlockParentTrait;

	/**
	 * @return null
	 */
	public function getIndex()
	{
		return null;
	}

	/**
	 * @return string
	 */
	public function getNodeType()
	{
		return NodeInterface::NODE_TYPE_DOCUMENT;
	}

	/**
	 * @return NodeInterface
	 */
	public function getParent()
	{
		return null;
	}

	/**
	 * @return bool
	 */
	public function hasParent()
	{
		return false;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function handle(HandlerInterface $markdomHandler)
	{
		$this->onHandle($markdomHandler);
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	private function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onDocumentBegin();
		$markdomHandler->onBlocksBegin();
		for ($i = 0, $n = $this->getBlocks()->size(); $i < $n; $i++) {
			$block = $this->getBlocks()->get($i);
			$block->onHandle($markdomHandler);
			if (!$this->getBlocks()->isLast($block)) {
				$markdomHandler->onNextBlock();
			}
		}
		$markdomHandler->onBlocksEnd();
		$markdomHandler->onDocumentEnd();
	}

	/**
	 * @return DocumentInterface
	 */
	public function getDocument()
	{
		return $this;
	}

}
