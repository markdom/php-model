<?php

declare(strict_types=1);

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\EmphasisContentInterface;

/**
 * Class EmphasisContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
class EmphasisContent extends AbstractContent implements EmphasisContentInterface
{

	use ContentParentTrait;

	/**
	 * @var int
	 */
	private $level;

	/**
	 * EmphasisContent constructor.
	 *
	 * @param int $level
	 */
	public function __construct(int $level)
	{
		$this->level = $level;
	}

	/**
	 * @return int
	 */
	public function getLevel(): int
	{
		return $this->level;
	}

	/**
	 * @param int $level
	 * @return $this
	 */
	public function setLevel(int $level)
	{
		$this->level = $level;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentParentType(): string
	{
		return self::CONTENT_PARENT_TYPE_EMPHASIS;
	}

	/**
	 * @return string
	 */
	public function getContentType(): string
	{
		return self::CONTENT_TYPE_EMPHASIS;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onEmphasisContentBegin($this->getLevel());
		$markdomHandler->onContentsBegin();
		for ($i = 0, $n = $this->getContents()->size(); $i < $n; $i++) {
			$content = $this->getContents()->get($i);
			$content->onHandle($markdomHandler);
			if (!$this->getContents()->isLast($content)) {
				$markdomHandler->onNextContent();
			}
		}
		$markdomHandler->onContentsEnd();
		$markdomHandler->onEmphasisContentEnd($this->getLevel());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
