<?php


namespace Donquixote\FlexiParser\Symbol\Numeric;


use Donquixote\FlexiParser\Symbol\SymbolInterface;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class UnsignedNumeric implements SymbolInterface {

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {

  }
}
