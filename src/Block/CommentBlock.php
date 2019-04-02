<?php

declare(strict_types=1);

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\CommentBlockInterface;

/**
 * Class CommentBlock
 *
 * @package Markdom\Model\Block
 */
class CommentBlock extends AbstractBlock implements CommentBlockInterface
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
	public function __construct(string $comment)
	{
		$this->comment = $comment;
	}

	/**
	 * @return string
	 */
	public function getComment(): string
	{
		return $this->comment;
	}

	/**
	 * @param string $comment
	 * @return $this
	 */
	public function setComment(string $comment)
	{
		$this->comment = $comment;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBlockType(): string
	{
		return self::BLOCK_TYPE_COMMENT;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onCommentBlock($this->getComment());
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
