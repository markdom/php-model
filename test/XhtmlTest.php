<?php

namespace Markdom\Test;

use Markdom\Dispatcher\Exception\DispatcherException;
use Markdom\Dispatcher\XmlDispatcher;
use Markdom\Handler\XhtmlHandler;
use Markdom\Model\Handler\ModelHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class XhtmlTest
 *
 * @package Markdom\Test
 */
class XhtmlTest extends TestCase
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

		// Dispatch the Markdom Document as XHTML string
		$handler = new XhtmlHandler();
		$handler
			->setEscapeHtml(true)
			->setBreakSoftBreaks(false);
		$document->dispatchTo($handler);
		$htmlString = $handler->getResult();
		$this->assertStringEqualsFile(__DIR__ . '/test-data.xhtml', $htmlString);
	}

}
