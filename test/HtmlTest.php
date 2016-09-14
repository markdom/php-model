<?php

namespace Markdom\Test;

use Markdom\Dispatcher\XmlDispatcher;
use Markdom\Handler\HtmlHandler;
use Markdom\Model\Handler\ModelHandler;

/**
 * Class HtmlTest
 *
 * @package Markdom\Test
 */
class HtmlTest extends \PHPUnit_Framework_TestCase
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

		// Dispatch the Markdom Document as HTML string
		$handler = new HtmlHandler();
		$handler
			->setEscapeHtml(true)
			->setBreakSoftBreaks(false);
		$document->dispatchTo($handler);
		$htmlString = $handler->getResult();
		$this->assertEquals(file_get_contents(__DIR__ . '/test-data.html'), $htmlString);
	}

}
