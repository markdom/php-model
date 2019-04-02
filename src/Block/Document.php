<?php

declare(strict_types=1);

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
class Document extends AbstractNode implements DocumentInterface
{

	use BlockParentTrait;

	/**
	 * @return int
	 */
	public function getIndex(): ?int
	{
		return null;
	}

	/**
	 * @return string
	 */
	public function getNodeType(): string
	{
		return NodeInterface::NODE_TYPE_DOCUMENT;
	}

	/**
	 * @return string
	 */
	public function getBlockParentType(): string
	{
		return self::BLOCK_PARENT_TYPE_DOCUMENT;
	}

	/**
	 * @return NodeInterface
	 */
	public function getParent(): ?NodeInterface
	{
		return null;
	}

	/**
	 * @return bool
	 */
	public function hasParent(): bool
	{
		return false;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return mixed
	 */
	public function dispatchTo(HandlerInterface $markdomHandler)
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
		return $markdomHandler->getResult();
	}

	/**
	 * @return bool
	 */
	public function isReusable(): bool
	{
		return true;
	}

	/**
	 * @return DocumentInterface
	 */
	public function getDocument(): DocumentInterface
	{
		return $this;
	}

}
