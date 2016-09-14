<?php

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\CodeContentInterface;

/**
 * Class CodeContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
final class CodeContent extends AbstractContent implements CodeContentInterface
{

	/**
	 * @var string
	 */
	private $code;

	/**
	 * CodeContent constructor.
	 *
	 * @param string $code
	 */
	public function __construct($code)
	{
		$this->code = $code;
	}

	/**
	 * @return string
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @param string $code
	 * @return $this
	 */
	public function setCode($code)
	{
		$this->code = $code;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType()
	{
		return self::CONTENT_TYPE_CODE;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onCodeContent($this->getCode());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
