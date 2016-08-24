<?php

namespace Markdom\Model\Content;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\ModelInterface\Content\ContentInterface;
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
	 * LinkContent constructor.
	 *
	 * @param string $uri
	 */
	public function __construct($uri)
	{
		$this->uri = $uri;
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
	final public function getContentType()
	{
		return ContentInterface::TYPE_LINK;
	}

	/**
	 * @param HandlerInterface $markdomHandler
	 */
	public function onHandle(HandlerInterface $markdomHandler)
	{
		$markdomHandler->onContentBegin($this->getContentType());
		$markdomHandler->onLinkContentBegin($this->getUri());
		$markdomHandler->onContentsBegin();
		for ($i = 0, $n = $this->getContents()->size(); $i < $n; $i++) {
			$content = $this->getContents()->get($i);
			$content->onHandle($markdomHandler);
			if (!$this->getContents()->isLast($content)) {
				$markdomHandler->onNextContent();
			}
		}
		$markdomHandler->onContentsEnd();
		$markdomHandler->onLinkContentEnd($this->getUri());
		$markdomHandler->onContentEnd($this->getContentType());
	}

}
