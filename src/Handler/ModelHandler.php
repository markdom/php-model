<?php

declare(strict_types=1);

namespace Markdom\Model\Handler;

use ChromaX\StackUtil\Stack;
use Markdom\HandlerInterface\HandlerInterface;
use Markdom\Model\Block\CodeBlock;
use Markdom\Model\Block\CommentBlock;
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
	public function onDocumentBegin(): void
	{
		$this->markdomDocument = new Document();
		$this->blockParentStack->push($this->markdomDocument);
	}

	/**
	 * @return void
	 */
	public function onDocumentEnd(): void
	{
		$this->blockParentStack->pop();
	}

	/**
	 * @return void
	 */
	public function onBlocksBegin(): void
	{
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function onBlockBegin(string $type): void
	{
	}

	/**
	 * @param string $code
	 * @param string $hint
	 * @return void
	 */
	public function onCodeBlock(string $code, ?string $hint = null): void
	{
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->addBlock(new CodeBlock($code, $hint));
	}

	/**
	 * @param string $comment
	 * @return void
	 */
	public function onCommentBlock(string $comment): void
	{
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->addBlock(new CommentBlock($comment));
	}

	/**
	 * @return void
	 */
	public function onDivisionBlock(): void
	{
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->addBlock(new DivisionBlock());
	}

	/**
	 * @param int $level
	 * @return void
	 */
	public function onHeadingBlockBegin(int $level): void
	{
		$heading = new HeadingBlock($level);
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->addBlock($heading);
		$this->contentParentStack->push($heading);
	}

	/**
	 * @param int $level
	 * @return void
	 */
	public function onHeadingBlockEnd(int $level): void
	{
		$this->contentParentStack->pop();
	}

	/**
	 * @return void
	 */
	public function onUnorderedListBlockBegin(): void
	{
		$list = new UnorderedListBlock();
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->addBlock($list);
		$this->listBlockStack->push($list);
	}

	/**
	 * @param int $startIndex
	 * @return void
	 */
	public function onOrderedListBlockBegin(int $startIndex): void
	{
		$list = new OrderedListBlock($startIndex);
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->addBlock($list);
		$this->listBlockStack->push($list);
	}

	/**
	 * @return void
	 */
	public function onListItemsBegin(): void
	{
	}

	/**
	 * @return void
	 */
	public function onListItemBegin(): void
	{
		$listItem = new ListItem();
		/** @var ListBlockInterface $parent */
		$parent = $this->listBlockStack->get();
		$parent->addItem($listItem);
		$this->blockParentStack->push($listItem);
	}

	/**
	 * @return void
	 */
	public function onListItemEnd(): void
	{
		$this->blockParentStack->pop();
	}

	/**
	 * @return void
	 */
	public function onNextListItem(): void
	{
	}

	/**
	 * @return void
	 */
	public function onListItemsEnd(): void
	{
	}

	/**
	 * @return void
	 */
	public function onUnorderedListBlockEnd(): void
	{
		$this->listBlockStack->pop();
	}

	/**
	 * @param int
	 * @return void
	 */
	public function onOrderedListBlockEnd(int $startIndex): void
	{
		$this->listBlockStack->pop();
	}

	/**
	 * @return void
	 */
	public function onParagraphBlockBegin(): void
	{
		$paragraph = new ParagraphBlock();
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->addBlock($paragraph);
		$this->contentParentStack->push($paragraph);
	}

	/**
	 * @return void
	 */
	public function onParagraphBlockEnd(): void
	{
		$this->contentParentStack->pop();
	}

	/**
	 * @return void
	 */
	public function onQuoteBlockBegin(): void
	{
		$quote = new QuoteBlock();
		/** @var BlockParentInterface $parent */
		$parent = $this->blockParentStack->get();
		$parent->addBlock($quote);
		$this->blockParentStack->push($quote);
	}

	/**
	 * @return void
	 */
	public function onQuoteBlockEnd(): void
	{
		$this->blockParentStack->pop();
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function onBlockEnd(string $type): void
	{
	}

	/**
	 * @return void
	 */
	public function onNextBlock(): void
	{
	}

	/**
	 * @return void
	 */
	public function onBlocksEnd(): void
	{
	}

	/**
	 * @return void
	 */
	public function onContentsBegin(): void
	{
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function onContentBegin(string $type): void
	{
	}

	/**
	 * @param string $code
	 * @return void
	 */
	public function onCodeContent(string $code): void
	{
		$code = new CodeContent($code);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->addContent($code);
	}

	/**
	 * @param int $level
	 * @return void
	 */
	public function onEmphasisContentBegin(int $level): void
	{
		$emphasis = new EmphasisContent($level);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->addContent($emphasis);
		$this->contentParentStack->push($emphasis);
	}

	/**
	 * @param int $level
	 * @return void
	 */
	public function onEmphasisContentEnd(int $level): void
	{
		$this->contentParentStack->pop();
	}

	/**
	 * @param string $uri
	 * @param string $title
	 * @param string $alternative
	 * @return void
	 */
	public function onImageContent(string $uri, ?string $title = null, ?string $alternative = null): void
	{
		$image = new ImageContent($uri, $title, $alternative);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->addContent($image);
	}

	/**
	 * @param bool $hard
	 * @return void
	 */
	public function onLineBreakContent(bool $hard): void
	{
		$linebreak = new LinebreakContent($hard);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->addContent($linebreak);
	}

	/**
	 * @param string $uri
	 * @param string $title
	 * @return void
	 */
	public function onLinkContentBegin(string $uri, ?string $title = null): void
	{
		$link = new LinkContent($uri, $title);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->addContent($link);
		$this->contentParentStack->push($link);
	}

	/**
	 * @param string $uri
	 * @param string $title
	 * @return void
	 */
	public function onLinkContentEnd(string $uri, ?string $title = null): void
	{
		$this->contentParentStack->pop();
	}

	/**
	 * @param string $text
	 * @return void
	 */
	public function onTextContent(string $text): void
	{
		$text = new TextContent($text);
		/** @var ContentParentInterface $parent */
		$parent = $this->contentParentStack->get();
		$parent->addContent($text);
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function onContentEnd(string $type): void
	{
	}

	/**
	 * @return void
	 */
	public function onNextContent(): void
	{
	}

	/**
	 * @return void
	 */
	public function onContentsEnd(): void
	{
	}

	/**
	 * @return Document
	 */
	public function getResult(): Document
	{
		return $this->markdomDocument;
	}

	/**
	 * Convenienance method to allow access to the listBlockStack by child classes
	 *
	 * @return Stack
	 */
	public function getListBlockStack(): Stack
	{
		return $this->listBlockStack;
	}

	/**
	 * Convenienance method to allow access to the listBlockStack by child classes
	 *
	 * @return Stack
	 */
	public function getBlockParentStack(): Stack
	{
		return $this->blockParentStack;
	}

	/**
	 * Convenienance method to allow access to the listBlockStack by child classes
	 *
	 * @return Stack
	 */
	public function getContentParentStack(): Stack
	{
		return $this->contentParentStack;
	}

}
