<?php

namespace Markdom\Test;

use Markdom\Dispatcher\Exception\DispatcherException;
use Markdom\Dispatcher\JsonDispatcher;
use Markdom\Handler\JsonHandler;
use Markdom\Model\Handler\ModelHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonTest
 *
 * @package Markdom\Test
 */
class JsonTest extends TestCase
{

	/**
	 * @throws DispatcherException
	 */
	public function testParseHandle(): void
	{
		// Dispatch a JSON file as Markdom Document
		$handler = new ModelHandler();
		$dispatcher = new JsonDispatcher(file_get_contents(__DIR__ . '/test-data.json'));
		$dispatcher->dispatchTo($handler);
		$document = $handler->getResult();

		// Dispatch the Markdom Document as JSON string
		$handler = new JsonHandler();
		$handler
			->setPrettyPrint(true)
			->setEscapeUnicode(true);
		$document->dispatchTo($handler);
		$jsonString = $handler->getResult();
		$this->assertStringEqualsFile(__DIR__ . '/test-data.json', $jsonString);
	}

}
