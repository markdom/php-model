<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\BlockInterface;
use Markdom\ModelInterface\Block\CommentBlockInterface;

/**
 * Class CommentBlock
 *
 * @package Markdom\Model\Block
 */
final class CommentBlock extends AbstractBlock implements CommentBlockInterface
{

	/**
	 * @var string
	 */
	private $comment;

	/**
	 * CommentBlock constructor.
	 *
	 * @param $comment
	 */
	public function __construct($comment)
	{
		$this->comment = $comment;
	}

	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->comment;
	}

	/**
	 * @param string $comment
	 * @return $this
	 */
	public function setComment($comment)
	{
		$this->comment = $comment;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBlockType()
	{
		return BlockInterface::TYPE_COMMENT;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onCommentBlock($this->getComment());
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
