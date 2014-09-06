<?php

namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation;

use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol\AnnotationSettingsInterface;
use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol\AnnotationSettingsProxy;
use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol\AnnotationSymbol;
use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol\AnnotationName;
use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol\AnnotationSettings;
use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol\CommentWithAnnotations;
use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol\SettingValue;
use Donquixote\FlexiParser\Grammar\GrammarBase;
use Donquixote\FlexiParser\Symbol\Identifier;
use Donquixote\FlexiParser\Symbol\JsonPrimitive;
use Donquixote\FlexiParser\Symbol\OneOf;
use Donquixote\FlexiParser\Symbol\Parens;
use Donquixote\FlexiParser\Symbol\SymbolInterface;

/**
 * @property Identifier $identifier
 * @property AnnotationSymbol $annotation
 * @property AnnotationName $annotationName
 * @property AnnotationSettings $annotationSettings
 * @property AnnotationSettingsProxy $annotationSettingsProxy
 * @property SettingValue $settingValue
 * @property SymbolInterface $plainValue
 * @property CommentWithAnnotations $commentWithAnnotations
 */
class DoctrineAnnotationGrammar extends GrammarBase {

  protected function get_annotation() {
    return new AnnotationSymbol($this->annotationName, $this->annotationSettingsProxy);
  }

  protected function get_identifier() {
    return new Identifier();
  }

  protected function get_annotationName() {
    return new AnnotationName($this->identifier);
  }

  protected function get_annotationSettingsProxy() {
    return new AnnotationSettingsProxy($this);
  }

  protected function get_annotationSettings() {
    return new AnnotationSettings($this->identifier, $this->settingValue);
  }

  protected function get_settingValue() {
    $oneOf = new OneOf(
      [
        new JsonPrimitive(),
        $this->annotation,
        new Parens($this->annotationSettingsProxy, '{', '}'),
      ]);

    return new SettingValue($oneOf);
  }

  protected function get_plainValue() {
    $symbols = [];
    $symbols['identifier'] = $this->identifier;
    $symbols['json'] = new JsonPrimitive();
    $symbols['annotation'] = $this->annotation;
    return new OneOf($symbols);
  }

  protected function get_commentWithAnnotations() {
    return new CommentWithAnnotations($this->annotation);
  }

} 
