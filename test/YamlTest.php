<?php

namespace Markdom\Test;

use Markdom\Dispatcher\Exception\DispatcherException;
use Markdom\Dispatcher\JsonDispatcher;
use Markdom\Handler\YamlHandler;
use Markdom\Model\Handler\ModelHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class YamlTest
 *
 * @package Markdom\Test
 */
class YamlTest extends TestCase
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

		// Dispatch the Markdom Document as Yaml string
		$handler = new YamlHandler();
		$handler
			->setPrettyPrint(false)
			->setWordWrap(true);
		$document->dispatchTo($handler);
		$yamlString = $handler->getResult();
		$this->assertStringEqualsFile(__DIR__ . '/test-data.yaml', $yamlString);
	}

}
