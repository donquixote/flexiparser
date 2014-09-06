<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;
use Donquixote\FlexiParser\Util;

class SeparatorRepeat extends Repeat {

  /**
   * @var SymbolInterface
   */
  protected $separator;

  /**
   * @param SymbolInterface $symbol
   * @param SymbolInterface $separator
   */
  function __construct(SymbolInterface $symbol, SymbolInterface $separator) {
    parent::__construct($symbol);
    $this->separator = $separator;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    $result = array();
    $first = true;
    while (true) {
      $index = $iterator->getIndex();
      try {
        if ($first) {
          $first = false;
        }
        else {
          $this->separator->parse($iterator);
        }
        $result[] = $this->symbol->parse($iterator);
      }
      catch (SymbolParseException $e) {
        $iterator->setIndex($index);
        break;
      }
    }
    return $result;
  }

} 
