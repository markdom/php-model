<?php

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\ContentInterface;
use Markdom\ModelInterface\Content\LinebreakContentInterface;

/**
 * Class LinebreakContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
final class LinebreakContent extends AbstractContent implements LinebreakContentInterface
{

	/**
	 * @var bool
	 */
	private $hard;

	/**
	 * LinebreakContent constructor.
	 *
	 * @param bool $hard
	 */
	public function __construct($hard)
	{
		$this->hard = $hard;
	}

	/**
	 * @return bool
	 */
	public function isHard()
	{
		return $this->hard;
	}

	/**
	 * @param bool $hard
	 * @return $this
	 */
	public function setHard($hard)
	{
		$this->hard = $hard;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType()
	{
		return ContentInterface::TYPE_LINE_BREAK;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onLineBreakContent($this->isHard());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
