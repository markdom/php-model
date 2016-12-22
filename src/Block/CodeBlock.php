<?php

namespace Markdom\Model\Block;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Block\CodeBlockInterface;

/**
 * Class CodeBlock
 *
 * @package Markenwerk\Markdom\Model\Block
 */
class CodeBlock extends AbstractBlock implements CodeBlockInterface
{

	/**
	 * @var string
	 */
	private $code;

	/**
	 * @var string
	 */
	private $hint;

	/**
	 * CodeBlock constructor.
	 *
	 * @param string $code
	 * @param string $hint
	 */
	public function __construct($code, $hint = null)
	{
		$this->code = $code;
		$this->hint = $hint;
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
	public function getHint()
	{
		return $this->hint;
	}

	/**
	 * @param string $hint
	 * @return $this
	 */
	public function setHint($hint)
	{
		$this->hint = $hint;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBlockType()
	{
		return self::BLOCK_TYPE_CODE;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onCodeBlock($this->getCode(), $this->getHint());
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
