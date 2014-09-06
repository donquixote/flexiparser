<?php

namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol;

use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Result\Annotation;
use Donquixote\FlexiParser\Symbol\Concat;
use Donquixote\FlexiParser\Symbol\Parens;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class AnnotationSymbol extends Concat {

  /**
   * @var Concat
   */
  private $concat;

  /**
   * Constructs an Annotation symbol.
   *
   * @param AnnotationName $annotationName
   * @param AnnotationSettingsInterface $annotationSettings
   */
  function __construct($annotationName, $annotationSettings) {
    $parens = new Parens($annotationSettings, '(', ')');
    $this->concat = new Concat([$annotationName, $parens]);
  }

  /**
   * @param TokenIterator $iterator
   *
   * @throws SymbolParseException
   * @return AnnotationSymbol
   */
  function parse(TokenIterator $iterator) {
    if ('@' !== $iterator->getToken()) {
      throw new SymbolParseException;
    }
    if ($iterator->hasSpaceAfter()) {
      // Whitespace after the '@'.
      throw new SymbolParseException;
    }
    $iterator->next();
    $result = $this->concat->parse($iterator);
    list($name, $settings) = $result;
    return new Annotation($name, $settings);
  }

} 
