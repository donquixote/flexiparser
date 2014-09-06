<?php


namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Symbol;


use Donquixote\FlexiParser\Symbol\Concat;
use Donquixote\FlexiParser\Symbol\ExactString;
use Donquixote\FlexiParser\Symbol\Identifier;
use Donquixote\FlexiParser\Symbol\OneOf;
use Donquixote\FlexiParser\Symbol\SeparatorRepeat;
use Donquixote\FlexiParser\Symbol\SymbolInterface;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class AnnotationSettings implements AnnotationSettingsInterface {

  /**
   * @var SeparatorRepeat
   */
  private $repeat;

  /**
   * @param Identifier $identifier
   * @param SymbolInterface $value
   */
  function __construct(Identifier $identifier, SymbolInterface $value) {
    $operator = new ExactString('=');
    $setting = new Concat([$identifier, $operator, $value]);
    $this->repeat = new SeparatorRepeat(
      new OneOf(['setting' => $setting, 'value' => $value]),
      new ExactString(','));
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed[]
   *
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    $result = array();
    $repeaterResult = $this->repeat->parse($iterator);
    foreach ($repeaterResult as $oneOfResult) {
      list($type, $match) = $oneOfResult;
      if ('setting' === $type) {
        list($key, , $value) = $match;
        $result[$key] = $value;
      }
      elseif ('value' === $type) {
        $result[] = $match;
      }
    }
    return $result;
  }

}
