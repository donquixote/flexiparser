<?php


namespace Donquixote\FlexiParser\Symbol\Numeric;


use Donquixote\FlexiParser\Symbol\SymbolInterface;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class Numeric implements SymbolInterface {

  /**
   * @var string
   */
  private $decimalSeparator;

  /**
   * @param string $decimalSeparator
   *   E.g. '.' or ','.
   */
  function __construct($decimalSeparator) {
    $this->decimalSeparator = $decimalSeparator;
  }

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
    if ($iterator->hasSpaceBefore()) {
      return $number;
    }
    if ($this->decimalSeparator !== $iterator->getToken()) {
      // E.g. "350#"
      return $number;
    }
    if ($iterator->hasSpaceAfter()) {
      // E.g. "350. "
      return $number;
    }
    $index = $iterator->getIndex();
    $iterator->next();
    $fractionToken = $iterator->getToken();
    if ((string)(int)$fractionToken === $fractionToken) {
      return (float)($number . '.' . $fractionToken);
    }
    $iterator->setIndex($index);
    return $number;
  }

}
