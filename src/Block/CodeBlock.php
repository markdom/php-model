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
	public function __construct(string $code, ?string $hint = null)
	{
		$this->code = $code;
		$this->hint = $hint;
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
	public function getHint(): ?string
	{
		return $this->hint;
	}

	/**
	 * @param string $hint
	 * @return $this
	 */
	public function setHint(string $hint)
	{
		$this->hint = $hint;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBlockType(): string
	{
		return self::BLOCK_TYPE_CODE;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 * @return void
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onBlockBegin($this->getBlockType());
		$markdomHandler->onCodeBlock($this->getCode(), $this->getHint());
		$markdomHandler->onBlockEnd($this->getBlockType());
	}

}
