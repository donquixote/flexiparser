<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\Tokenizer\TokenIterator;
use Donquixote\FlexiParser\Util;

class Concat implements SymbolInterface {

  /**
   * @var array
   */
  protected $symbols;

  /**
   * @param SymbolInterface[] $symbols
   */
  function __construct(array $symbols) {
    $this->symbols = $symbols;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed[]
   */
  function parse(TokenIterator $iterator) {
    $result = array();
    foreach ($this->symbols as $key => $symbol) {
      $result[$key] = $s = $symbol->parse($iterator);
    }
    return $result;
  }

}
