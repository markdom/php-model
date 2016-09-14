<?php

namespace Markdom\Test;

use Markdom\Dispatcher\XmlDispatcher;
use Markdom\Handler\XmlHandler;
use Markdom\Model\Handler\ModelHandler;

/**
 * Class XmlTest
 *
 * @package Markdom\Test
 */
class XmlTest extends \PHPUnit_Framework_TestCase
{

	public function testParseHandle()
	{
		// Dispatch a XML file as Markdom Document
		$xmlString = file_get_contents(__DIR__ . '/test-data.xml');
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
		$document->handle($handler);
		$xmlString = $handler->getResult()->saveXML();
		$this->assertEquals(file_get_contents(__DIR__ . '/test-data.xml'), $xmlString);
	}

}
