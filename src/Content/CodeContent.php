<?php

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\CodeContentInterface;

/**
 * Class CodeContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
class CodeContent extends AbstractContent implements CodeContentInterface
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
	public function __construct(string $code)
	{
		$this->code = $code;
	}

	/**
	 * @return string
	 */
	public function getCode(): string
	{
		return $this->code;
	}

	/**
	 * @param string $code
	 * @return $this
	 */
	public function setCode(string $code)
	{
		$this->code = $code;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType(): string
	{
		return self::CONTENT_TYPE_CODE;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onCodeContent($this->getCode());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
