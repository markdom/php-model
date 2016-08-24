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
	private $hardbreak;

	/**
	 * LinebreakContent constructor.
	 *
	 * @param bool $hardbreak
	 */
	public function __construct($hardbreak)
	{
		$this->hardbreak = $hardbreak;
	}

	/**
	 * @return boolean
	 */
	public function isHardbreak()
	{
		return $this->hardbreak;
	}

	/**
	 * @param boolean $hardbreak
	 * @return $this
	 */
	public function setHardbreak($hardbreak)
	{
		$this->hardbreak = $hardbreak;
		return $this;
	}

	/**
	 * @return string
	 */
	final public function getContentType()
	{
		return ContentInterface::TYPE_LINE_BREAK;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onLineBreakContent($this->isHardbreak());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
