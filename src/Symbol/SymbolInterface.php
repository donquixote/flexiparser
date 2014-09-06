<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

interface SymbolInterface {

  /**
   * Attempts to parse a value from the current iterator position forward.
   *
   * In case of success, the iterator position advances to the end of the parsed
   * substring.
   * In case of failure, the iterator position will be unpredictable, and a
   * SymbolParseException is thrown.
   * Usually some code further up will catch this exception, and reset the
   * iterator to the last known safe position.
   *
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator);

} 
