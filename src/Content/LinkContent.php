<?php

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\LinkContentInterface;

/**
 * Class LinkContent
 *
 * @package Markenwerk\Markdom\Model\Content
 */
final class LinkContent extends AbstractContent implements LinkContentInterface
{

	use ContentParentTrait;

	/**
	 * @var string
	 */
	private $uri;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * LinkContent constructor.
	 *
	 * @param string $uri
	 * @param string $title
	 */
	public function __construct($uri, $title = null)
	{
		$this->uri = $uri;
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * @param string $uri
	 * @return $this
	 */
	public function setUri($uri)
	{
		$this->uri = $uri;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentParentType()
	{
		return self::CONTENT_PARENT_TYPE_LINK;
	}

	/**
	 * @return string
	 */
	public function getContentType()
	{
		return self::CONTENT_TYPE_LINK;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onLinkContentBegin($this->getUri(), $this->getTitle());
		$markdomHandler->onContentsBegin();
		for ($i = 0, $n = $this->getContents()->size(); $i < $n; $i++) {
			$content = $this->getContents()->get($i);
			$content->onHandle($markdomHandler);
			if (!$this->getContents()->isLast($content)) {
				$markdomHandler->onNextContent();
			}
		}
		$markdomHandler->onContentsEnd();
		$markdomHandler->onLinkContentEnd($this->getUri(), $this->getTitle());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
