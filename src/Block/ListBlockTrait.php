<?php

namespace Markdom\Model\Block;

use Markdom\ModelInterface\Block\ListItemSequenceInterface;

/**
 * Class ListBlockTrait
 *
 * @package Markenwerk\Markdom\Model\Block
 */
trait ListBlockTrait
{

	/**
	 * @var ListItemSequenceInterface
	 */
	private $listItems;

	/**
	 * @return ListItemSequenceInterface
	 */
	final public function getListItems()
	{
		if (is_null($this->listItems)) {
			/** @noinspection PhpParamsInspection */
			$this->listItems = new ListItemSequence($this);
		}
		return $this->listItems;
	}

}
