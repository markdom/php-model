<?php

namespace Markdom\Model\Block;

use Markdom\ModelInterface\Block\ListItemInterface;
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
	final public function getItems(): ListItemSequenceInterface
	{
		if (is_null($this->listItems)) {
			/** @noinspection PhpParamsInspection */
			$this->listItems = new ListItemSequence($this);
		}
		return $this->listItems;
	}

	/**
	 * @param ListItemInterface $listItem
	 * @return $this
	 */
	final public function addItem(ListItemInterface $listItem)
	{
		$this->getItems()->append($listItem);
		return $this;
	}

	/**
	 * @param ListItemInterface[] $listItems
	 * @return $this
	 */
	final public function addItems(array $listItems)
	{
		foreach ($listItems as $listItem) {
			$this->addItem($listItem);
		}
		return $this;
	}

}
