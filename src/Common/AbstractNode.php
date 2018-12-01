<?php

namespace Markdom\Model\Common;

use Markdom\ModelInterface\Common\NodeInterface;

/**
 * Class AbstractNode
 *
 * @package Markenwerk\Markdom\Model\Common
 */
abstract class AbstractNode implements NodeInterface
{

	/**
	 * @return bool
	 */
	final public function hasChildren(): bool
	{
		$children = $this->getChildren();
		if ($children === null) {
			return false;
		}
		return !$children->isEmpty();
	}

	/**
	 * @return int
	 */
	final public function countChildren(): int
	{
		$children = $this->getChildren();
		if ($children === null) {
			return 0;
		}
		return $children->count();
	}

}
