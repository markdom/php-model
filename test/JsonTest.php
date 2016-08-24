<?php

namespace Markdom\Test;

use Markdom\Dispatcher\JsonDispatcher;
use Markdom\Handler\JsonHandler;
use Markdom\Model\Handler\ModelHandler;

/**
 * Class JsonTest
 *
 * @package Markdom\Test
 */
class JsonTest extends \PHPUnit_Framework_TestCase
{

	public function testParseHandle()
	{
		// Dispatch a JSON file as Markdom Document
		$handler = new ModelHandler();
		$dispatcher = new JsonDispatcher($handler);
		$dispatcher->process(file_get_contents(__DIR__.'/test-data.json'));
		$document = $handler->getResult();

		// Dispatch the Markdom Document as JSON string
		$handler = new JsonHandler(true, true);
		$document->handle($handler);
		$jsonString = $handler->getResult();
		$this->assertEquals(file_get_contents(__DIR__ . '/test-data.json'), $jsonString);
	}

}
