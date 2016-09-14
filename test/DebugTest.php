<?php

namespace Markdom\Test;

use Markdom\Dispatcher\JsonDispatcher;
use Markdom\Handler\DebugHandler;
use Markdom\Model\Handler\ModelHandler;

/**
 * Class DebugTest
 *
 * @package Markdom\Test
 */
class DebugTest extends \PHPUnit_Framework_TestCase
{

	public function testParseHandle()
	{
		// Dispatch a JSON file as Markdom Document
		$handler = new ModelHandler();
		$dispatcher = new JsonDispatcher(file_get_contents(__DIR__ . '/test-data.json'));
		$dispatcher->dispatchTo($handler);
		$document = $handler->getResult();

		// Dispatch the Markdom Document as JSON string
		$handler = new DebugHandler();
		$document->handle($handler);
		$debugString = $handler->getResult();
		$this->assertEquals(file_get_contents(__DIR__ . '/test-data.debug.txt'), $debugString);
	}

}
