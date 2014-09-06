<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class RepeatWord extends Repeat {

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    $result = array();
    $first = true;
    while (true) {
      $index = $iterator->getIndex();
      try {
        if ($first) {
          $first = false;
        }
        elseif ($iterator->hasSpaceBefore()) {
          throw new SymbolParseException;
        }
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
