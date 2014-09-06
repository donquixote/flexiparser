<?php


namespace Donquixote\FlexiParser\Symbol\Numeric;

use Donquixote\FlexiParser\Symbol\SymbolInterface;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class UnsignedInteger implements SymbolInterface {

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    $token = $iterator->getToken();
    $number = (int)$token;
    if ((string)$number === $token) {
      return $number;
    }
    throw new SymbolParseException;
  }

  static function parseStatic(TokenIterator $iterator) {

  }

}
