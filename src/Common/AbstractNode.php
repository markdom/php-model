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
	public function hasChildren()
	{
		return !$this->getChildren()->isEmpty();
	}

	/**
	 * @return int
	 */
	public function countChildren()
	{
		return $this->getChildren()->count();
	}

}
