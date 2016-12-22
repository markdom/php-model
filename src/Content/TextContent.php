<?php

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\TextContentInterface;

/**
 * Class TextContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
class TextContent extends AbstractContent implements TextContentInterface
{

	/**
	 * @var string
	 */
	private $text;

	/**
	 * TextContent constructor.
	 *
	 * @param string $text
	 */
	public function __construct($text)
	{
		$this->text = $text;
	}

	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @param string $text
	 * @return $this
	 */
	public function setText($text)
	{
		$this->text = $text;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType()
	{
		return self::CONTENT_TYPE_TEXT;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onTextContent($this->getText());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
