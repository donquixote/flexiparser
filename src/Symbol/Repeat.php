<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class Repeat implements SymbolInterface {

  /**
   * @var SymbolInterface
   */
  protected $symbol;

  /**
   * @param SymbolInterface $symbol
   */
  function __construct(SymbolInterface $symbol) {
    $this->symbol = $symbol;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    $result = array();
    while (true) {
      $index = $iterator->getIndex();
      try {
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
