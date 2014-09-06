<?php


namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol;


use Donquixote\FlexiParser\Symbol\SymbolInterface;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class PlainValue implements SymbolInterface {

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    // TODO: Implement parse() method.
  }

}
