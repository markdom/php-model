<?php

namespace Markdom\Model\Content;

use Markdom\ModelInterface\Content\ContentInterface;
use Markdom\ModelInterface\Content\ContentSequenceInterface;

/**
 * Class ContentParentTrait
 *
 * @package Markenwerk\Markdom\Model\Content
 */
trait ContentParentTrait
{

	/**
	 * @var ContentSequenceInterface
	 */
	private $contents;

	/**
	 * @return ContentSequenceInterface
	 */
	final public function getContents()
	{
		if (is_null($this->contents)) {
			/** @noinspection PhpParamsInspection */
			$this->contents = new ContentSequence($this);
		}
		return $this->contents;
	}

	/**
	 * @return ContentSequenceInterface
	 */
	final public function getChildren()
	{
		return $this->getContents();
	}

	/**
	 * @param ContentInterface $content
	 * @return $this
	 */
	public function addContent(ContentInterface $content)
	{
		$this->getContents()
			->append($content);
		return $this;
	}

}
