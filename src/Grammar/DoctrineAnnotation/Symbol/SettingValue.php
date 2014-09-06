<?php


namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol;


use Donquixote\FlexiParser\Symbol\JsonPrimitive;
use Donquixote\FlexiParser\Symbol\OneOf;
use Donquixote\FlexiParser\Symbol\SymbolInterface;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class SettingValue implements SymbolInterface {

  /**
   * @var OneOf
   */
  private $oneOf;

  /**
   * @param OneOf $oneOf
   */
  function __construct(OneOf $oneOf) {
    $this->oneOf = $oneOf;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    list(, $result) = $this->oneOf->parse($iterator);
    return $result;
  }

}
