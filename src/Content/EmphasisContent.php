<?php

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\ContentInterface;
use Markdom\ModelInterface\Content\EmphasisContentInterface;

/**
 * Class EmphasisContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
final class EmphasisContent extends AbstractContent implements EmphasisContentInterface
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
	public function __construct($level)
	{
		$this->level = $level;
	}

	/**
	 * @return int
	 */
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * @param int $level
	 * @return $this
	 */
	public function setLevel($level)
	{
		$this->level = $level;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType()
	{
		return ContentInterface::TYPE_EMPHASIS;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler)
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
