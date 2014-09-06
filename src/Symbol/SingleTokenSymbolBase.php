<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

abstract class SingleTokenSymbolBase implements SymbolInterface {

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   */
  function parse(TokenIterator $iterator) {
    $token = $iterator->getToken();
    $iterator->next();
    return $this->parseToken($token);
  }

  /**
   * @param string $token
   *
   * @return mixed
   * @throws SymbolParseException
   */
  abstract protected function parseToken($token);

}
