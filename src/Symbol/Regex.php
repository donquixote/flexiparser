<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;

class Regex extends SingleTokenSymbolBase {

  /**
   * @var string
   */
  private $regex;

  /**
   * @param string $regex
   */
  function __construct($regex) {
    $this->regex = $regex;
  }

  /**
   * @param string $token
   *
   * @throws SymbolParseException
   * @return string[]
   */
  function parseToken($token) {
    if (preg_match($this->regex, $token, $m)) {
      return $m;
    }
    throw new SymbolParseException();
  }
}
