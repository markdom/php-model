<?php

namespace Markdom\Test;

use Markdom\Dispatcher\Exception\DispatcherException;
use Markdom\Dispatcher\JsonDispatcher;
use Markdom\Handler\DebugHandler;
use Markdom\Model\Handler\ModelHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class DebugTest
 *
 * @package Markdom\Test
 */
class DebugTest extends TestCase
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
		$handler = new DebugHandler();
		$document->dispatchTo($handler);
		$debugString = $handler->getResult();
		$this->assertStringEqualsFile(__DIR__ . '/test-data.debug.txt', $debugString);
	}

}
