<?php


namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol;


use Donquixote\FlexiParser\Symbol\SymbolInterface;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class CommentWithAnnotations implements SymbolInterface {

  /**
   * @var AnnotationSymbol
   */
  private $annotation;

  /**
   * @param AnnotationSymbol $annotation
   */
  function __construct(AnnotationSymbol $annotation) {
    $this->annotation = $annotation;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   */
  function parse(TokenIterator $iterator) {
    $annotations = array();
    while ($iterator->valid()) {
      if ('@' !== $iterator->getToken()) {
        $iterator->next();
        continue;
      }
      else {
        $innerIndex = $iterator->getIndex();
        try {
          $annotations[] = $this->annotation->parse($iterator);
          # $outerIndex = $iterator->getIndex();
        }
        catch (SymbolParseException $e) {
          // This was not really an annotation, so move on to the next '@'.
          $iterator->setIndex($innerIndex + 1);
        }
      }
    }
    return $annotations;
  }
}
