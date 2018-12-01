<?php

namespace Markdom\Test;

use Markdom\Dispatcher\Exception\DispatcherException;
use Markdom\Dispatcher\XmlDispatcher;
use Markdom\Handler\XmlHandler;
use Markdom\Model\Handler\ModelHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class XmlTest
 *
 * @package Markdom\Test
 */
class XmlTest extends TestCase
{

	/**
	 * @throws DispatcherException
	 */
	public function testParseHandle(): void
	{
		// Dispatch a XML file as Markdom Document
		$xmlString = file_get_contents(__DIR__ . '/test-data.xml');
		/** @noinspection PhpComposerExtensionStubsInspection */
		$xmlDocument = new \DOMDocument();
		$xmlDocument->preserveWhiteSpace = false;
		$xmlDocument->loadXML($xmlString);
		$handler = new ModelHandler();
		$dispatcher = new XmlDispatcher($xmlDocument);
		$dispatcher->dispatchTo($handler);
		$document = $handler->getResult();

		// Dispatch the Markdom Document as XML string
		$handler = new XmlHandler();
		$handler->setPrettyPrint(true);
		$document->dispatchTo($handler);
		$xmlString = $handler->getResult()->saveXML();
		$this->assertStringEqualsFile(__DIR__ . '/test-data.xml', $xmlString);
	}

}
