<?php


namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol;


use Donquixote\FlexiParser\Symbol\Identifier;
use Donquixote\FlexiParser\Symbol\SymbolInterface;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class AnnotationName implements SymbolInterface {

  /**
   * @var Identifier
   */
  private $identifier;

  /**
   * @param Identifier $identifier
   */
  function __construct(Identifier $identifier) {
    $this->identifier = $identifier;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    if ('\\' !== $iterator->getToken()) {
      return $this->identifier->parse($iterator);
    }
    $pieces = array();
    while (true) {
      if ($iterator->hasSpaceAfter()) {
        throw new SymbolParseException;
      }
      $iterator->next();
      $pieces[] = $this->identifier->parse($iterator);
      $iterator->next();
      if ($iterator->hasSpaceBefore()) {
        break;
      }
      if ('\\' !== $iterator->getToken()) {
        break;
      }
    }
    return implode('\\', $pieces);
  }

}
