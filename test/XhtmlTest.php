<?php

namespace Markdom\Test;

use Markdom\Dispatcher\XmlDispatcher;
use Markdom\Handler\XhtmlHandler;
use Markdom\Model\Handler\ModelHandler;

/**
 * Class XhtmlTest
 *
 * @package Markdom\Test
 */
class XhtmlTest extends \PHPUnit_Framework_TestCase
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

		// Dispatch the Markdom Document as XHTML string
		$handler = new XhtmlHandler();
		$handler
			->setEscapeHtml(true)
			->setBreakSoftBreaks(false);
		$document->handle($handler);
		$htmlString = $handler->getResult();
		$this->assertEquals(file_get_contents(__DIR__ . '/test-data.xhtml'), $htmlString);
	}

}
