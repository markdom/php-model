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
	final public function hasChildren()
	{
		return !$this->getChildren()->isEmpty();
	}

	/**
	 * @return int
	 */
	final public function countChildren()
	{
		return $this->getChildren()->count();
	}

}
