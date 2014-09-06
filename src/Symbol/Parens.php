<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\TokenIterator;

class Parens implements SymbolInterface {

  /**
   * @var SymbolInterface
   */
  private $wrapped;

  /**
   * @var string
   */
  private $left;

  /**
   * @var string
   */
  private $right;

  /**
   * @param SymbolInterface $wrapped
   * @param string $left
   * @param string $right
   */
  function __construct($wrapped, $left, $right) {
    $this->wrapped = $wrapped;
    $this->left = $left;
    $this->right = $right;
  }

  /**
   * @param TokenIterator $iterator
   *
   * @return mixed
   * @throws SymbolParseException
   */
  function parse(TokenIterator $iterator) {
    if ($this->left !== $iterator->getToken()) {
      throw new SymbolParseException;
    }
    $iterator->next();
    $result = $this->wrapped->parse($iterator);
    if ($this->right !== $iterator->getToken()) {
      throw new SymbolParseException;
    }
    $iterator->next();
    return $result;
  }
}
