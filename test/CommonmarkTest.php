<?php

namespace Markdom\Test;

use Markdom\Dispatcher\JsonDispatcher;
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
		// Dispatch a JSON file as Markdom Document
		// TODO: Replace with a CommonmarkDispatcher after implementing the HTML block and inline HTML handling
		$handler = new ModelHandler();
		$dispatcher = new JsonDispatcher($handler);
		$dispatcher->process(file_get_contents(__DIR__ . '/test-data.json'));
		$document = $handler->getResult();

		// Dispatch the Markdom Document as Commonmark string
		$handler = new CommonmarkHandler();
		$document->handle($handler);
		$commonmarkString = $handler->getResult();
		$this->assertEquals(file_get_contents(__DIR__ . '/test-data.md'), $commonmarkString);
	}

}
