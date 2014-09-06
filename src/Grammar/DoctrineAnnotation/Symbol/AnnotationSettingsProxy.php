<?php


namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol;

use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\DoctrineAnnotationGrammar;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class AnnotationSettingsProxy implements AnnotationSettingsInterface {

  /**
   * @var DoctrineAnnotationGrammar
   */
  private $grammar;

  /**
   * @var AnnotationSettings
   */
  private $annotationSettings;

  /**
   * @param DoctrineAnnotationGrammar $grammar
   */
  function __construct(DoctrineAnnotationGrammar $grammar) {
    $this->grammar = $grammar;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed[]
   *
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    if (!isset($this->annotationSettings)) {
      $this->annotationSettings = $this->grammar->annotationSettings;
    }
    return $this->annotationSettings->parse($iterator);
  }

}
