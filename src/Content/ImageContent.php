<?php

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\ImageContentInterface;

/**
 * Class ImageContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
class ImageContent extends AbstractContent implements ImageContentInterface
{

	/**
	 * @var string
	 */
	private $uri;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $alternative;

	/**
	 * ImageContent constructor.
	 *
	 * @param string $uri
	 * @param string $title
	 * @param string $alternative
	 */
	public function __construct(string $uri, ?string $title = null, ?string $alternative = null)
	{
		$this->uri = $uri;
		$this->title = $title;
		$this->alternative = $alternative;
	}

	/**
	 * @return string
	 */
	public function getUri(): string
	{
		return $this->uri;
	}

	/**
	 * @param string $uri
	 * @return $this
	 */
	public function setUri(string $uri)
	{
		$this->uri = $uri;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitle(string $title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAlternative(): ?string
	{
		return $this->alternative;
	}

	/**
	 * @param string $alternative
	 * @return $this
	 */
	public function setAlternative(string $alternative)
	{
		$this->alternative = $alternative;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType(): string
	{
		return self::CONTENT_TYPE_IMAGE;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler): void
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onImageContent($this->getUri(), $this->getTitle(), $this->getAlternative());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
