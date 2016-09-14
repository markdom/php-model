<?php

namespace Markdom\Test;

use Markdom\Dispatcher\CommonmarkDispatcher;
use Markdom\Handler\CommonmarkHandler;
use Markdom\Model\Handler\ModelHandler;

/**
 * Class CommonmarkTest
 *
 * @package Markdom\Test
 */
class CommonmarkTest extends \PHPUnit_Framework_TestCase
{

	public function testParseHandle()
	{
		// Dispatch a Commonmark file as Markdom Document
		$handler = new ModelHandler();
		$dispatcher = new CommonmarkDispatcher(file_get_contents(__DIR__ . '/test-data.md'));
		$dispatcher->dispatchTo($handler);
		$document = $handler->getResult();

		// Dispatch the Markdom Document as Commonmark string
		$handler = new CommonmarkHandler();
		$document->handle($handler);
		$commonmarkString = $handler->getResult();
		$this->assertEquals(file_get_contents(__DIR__ . '/test-result.md'), $commonmarkString);
	}

}
