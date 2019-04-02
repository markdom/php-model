<?php

declare(strict_types=1);

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\LinebreakContentInterface;

/**
 * Class LinebreakContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
class LinebreakContent extends AbstractContent implements LinebreakContentInterface
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
	public function __construct(bool $hard)
	{
		$this->hard = $hard;
	}

	/**
	 * @return bool
	 */
	public function isHard(): bool
	{
		return $this->hard;
	}

	/**
	 * @param bool $hard
	 * @return $this
	 */
	public function setHard(bool $hard)
	{
		$this->hard = $hard;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType(): string
	{
		return self::CONTENT_TYPE_LINE_BREAK;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onLineBreakContent($this->isHard());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
