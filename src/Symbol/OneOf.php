<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class OneOf implements SymbolInterface {

  /**
   * @var array
   */
  private $symbols;

  /**
   * @param SymbolInterface[] $symbols
   */
  function __construct(array $symbols) {
    $this->symbols = $symbols;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @throws SymbolParseException
   * @return array
   */
  function parse(TokenIterator $iterator) {
    $index = $iterator->getIndex();
    foreach ($this->symbols as $key => $symbol) {
      try {
        $result = $symbol->parse($iterator);
        return array($key, $result);
      }
      catch (SymbolParseException $e) {
        $iterator->setIndex($index);
      }
    }
    throw new SymbolParseException();
  }
}
