<?php

namespace Markdom\Model\Handler;

use Markdom\HandlerInterface\HandlerInterface;
use Markdom\Model\Block\CodeBlock;
use Markdom\Model\Block\DivisionBlock;
use Markdom\Model\Block\Document;
use Markdom\Model\Block\HeadingBlock;
use Markdom\Model\Block\ListItem;
use Markdom\Model\Block\OrderedListBlock;
use Markdom\Model\Block\ParagraphBlock;
use Markdom\Model\Block\QuoteBlock;
use Markdom\Model\Block\UnorderedListBlock;
use Markdom\Model\Content\CodeContent;
use Markdom\Model\Content\EmphasisContent;
use Markdom\Model\Content\ImageContent;
use Markdom\Model\Content\LinebreakContent;
use Markdom\Model\Content\LinkContent;
use Markdom\Model\Content\TextContent;
use Markdom\ModelInterface\Block\BlockParentInterface;
use Markdom\ModelInterface\Block\ListBlockInterface;
use Markdom\ModelInterface\Content\ContentParentInterface;
use Markenwerk\StackUtil\Stack;

/**
 * Class ModelHandler
 *
 * @package Markdom\Model\Handler
 */
class ModelHandler implements HandlerInterface
{

	/**
	 * @var Document
	 */
	private $markdomDocument;

	/**
	 * @var Stack
	 */
	private $listBlockStack;

	/**
	 * @var Stack
	 */
	private $blockParentStack;

	/**
	 * @var Stack
	 */
	private $contentParentStack;

	/**
	 * ModelHandler constructor.
	 */
	public function __construct()
	{
		$this->listBlockStack = new Stack();
		$this->blockParentStack = new Stack();
		$this->contentParentStack = new Stack();
	}

	/**
	 * @return void
	 */
	public function onDocumentBegin()
	{
		$this->markdomDocument = new Document();
		$this->blockParentStack->push($this->markdomDocument);
	}

	/**
	 * @return void
	 */
	public function onDocumentEnd()
	{
		$this->blockParentStack->pop();
	}

	/**
	 * @return void
	 */
	public function onBlocksBegin()
	{
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function onBlockBegin($type)
	{
	}

	/**
	 * @param string $code
	 * @param string $hint
	 * @return void
	 */
	public function onCodeBlock($code, $hint = null)
	{
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->getBlocks()->append(new CodeBlock($code, $hint));
	}

	/**
	 * @return void
	 */
	public function onDivisionBlock()
	{
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->getBlocks()->append(new DivisionBlock());
	}

	/**
	 * @param int $level
	 * @return void
	 */
	public function onHeadingBlockBegin($level)
	{
		$heading = new HeadingBlock($level);
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->getBlocks()->append($heading);
		$this->contentParentStack->push($heading);
	}

	/**
	 * @param int $level
	 * @return void
	 */
	public function onHeadingBlockEnd($level)
	{
		$this->contentParentStack->pop();
	}

	/**
	 * @return void
	 */
	public function onUnorderedListBlockBegin()
	{
		$list = new UnorderedListBlock();
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->getBlocks()->append($list);
		$this->listBlockStack->push($list);
	}

	/**
	 * @param int $startIndex
	 * @return void
	 */
	public function onOrderedListBlockBegin($startIndex)
	{
		$list = new OrderedListBlock($startIndex);
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->getBlocks()->append($list);
		$this->listBlockStack->push($list);
	}

	/**
	 * @return void
	 */
	public function onListItemsBegin()
	{
	}

	/**
	 * @return void
	 */
	public function onListItemBegin()
	{
		$listItem = new ListItem();
		/** @var ListBlockInterface $parent */
		$parent = $this->listBlockStack->get();
		$parent->getListItems()->append($listItem);
		$this->blockParentStack->push($listItem);
	}

	/**
	 * @return void
	 */
	public function onListItemEnd()
	{
		$this->blockParentStack->pop();
	}

	/**
	 * @return void
	 */
	public function onNextListItem()
	{
	}

	/**
	 * @return void
	 */
	public function onListItemsEnd()
	{
	}

	/**
	 * @return void
	 */
	public function onUnorderedListBlockEnd()
	{
		$this->listBlockStack->pop();
	}

	/**
	 * @param int
	 * @return void
	 */
	public function onOrderedListBlockEnd($startIndex)
	{
		$this->listBlockStack->pop();
	}

	/**
	 * @return void
	 */
	public function onParagraphBlockBegin()
	{
		$paragraph = new ParagraphBlock();
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->getBlocks()->append($paragraph);
		$this->contentParentStack->push($paragraph);
	}

	/**
	 * @return void
	 */
	public function onParagraphBlockEnd()
	{
		$this->contentParentStack->pop();
	}

	/**
	 * @return void
	 */
	public function onQuoteBlockBegin()
	{
		$quote = new QuoteBlock();
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->getBlocks()->append($quote);
		$this->blockParentStack->push($quote);
	}

	/**
	 * @return void
	 */
	public function onQuoteBlockEnd()
	{
		$this->blockParentStack->pop();
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function onBlockEnd($type)
	{
	}

	/**
	 * @return void
	 */
	public function onNextBlock()
	{
	}

	/**
	 * @return void
	 */
	public function onBlocksEnd()
	{
	}

	/**
	 * @return void
	 */
	public function onContentsBegin()
	{
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function onContentBegin($type)
	{
	}

	/**
	 * @param string $code
	 * @return void
	 */
	public function onCodeContent($code)
	{
		$code = new CodeContent($code);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->getContents()->append($code);
	}

	/**
	 * @param int $level
	 * @return void
	 */
	public function onEmphasisContentBegin($level)
	{
		$emphasis = new EmphasisContent($level);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->getContents()->append($emphasis);
		$this->contentParentStack->push($emphasis);
	}

	/**
	 * @param int $level
	 * @return void
	 */
	public function onEmphasisContentEnd($level)
	{
		$this->contentParentStack->pop();
	}

	/**
	 * @param string $uri
	 * @param string $title
	 * @param string $alternative
	 * @return void
	 */
	public function onImageContent($uri, $title = null, $alternative = null)
	{
		$image = new ImageContent($uri, $title, $alternative);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->getContents()->append($image);
	}

	/**
	 * @param bool $hard
	 * @return void
	 */
	public function onLineBreakContent($hard)
	{
		$linebreak = new LinebreakContent($hard);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->getContents()->append($linebreak);
	}

	/**
	 * @param string $uri
	 * @return void
	 */
	public function onLinkContentBegin($uri)
	{
		$link = new LinkContent($uri);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->getContents()->append($link);
		$this->contentParentStack->push($link);
	}

	/**
	 * @param string $uri
	 * @return void
	 */
	public function onLinkContentEnd($uri)
	{
		$this->contentParentStack->pop();
	}

	/**
	 * @param string $text
	 * @return void
	 */
	public function onTextContent($text)
	{
		$text = new TextContent($text);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->getContents()->append($text);
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function onContentEnd($type)
	{
	}

	/**
	 * @return void
	 */
	public function onNextContent()
	{
	}

	/**
	 * @return void
	 */
	public function onContentsEnd()
	{
	}

	/**
	 * @return Document
	 */
	public function getResult()
	{
		return $this->markdomDocument;
	}

}
