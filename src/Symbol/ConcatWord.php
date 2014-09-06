<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class ConcatWord extends Concat {

  /**
   * @param TokenIterator $iterator
   *
   * @throws SymbolParseException
   * @return mixed[]
   */
  function parse(TokenIterator $iterator) {
    $result = array();
    $first = true;
    foreach ($this->symbols as $key => $symbol) {
      if ($first) {
        $first = false;
      }
      elseif ($iterator->hasSpaceBefore()) {
        throw new SymbolParseException;
      }
      $result[$key] = $symbol->parse($iterator);
    }
    return $result;
  }

} 
