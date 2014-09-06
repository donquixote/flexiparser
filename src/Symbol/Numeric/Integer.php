<?php


namespace Donquixote\FlexiParser\Symbol\Numeric;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class Integer {

  /**
   * @param TokenIterator $iterator
   *
   * @return float|int
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    if ('-' === $iterator->getToken()) {
      if ($iterator->hasSpaceAfter()) {
        throw new SymbolParseException;
      }
      $iterator->next();
      return - $this->parseUnsigned($iterator);
    }
    else {
      return $this->parseUnsigned($iterator);
    }
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return float|int
   * @throws SymbolParseException
   */
  private function parseUnsigned(TokenIterator $iterator) {
    $token = $iterator->getToken();
    $number = (int)$token;
    if ((string)$number !== $token) {
      throw new SymbolParseException;
    }
    $iterator->next();
    return $number;
  }

} 
