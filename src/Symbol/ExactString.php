<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;

class ExactString extends SingleTokenSymbolBase {

  /**
   * @var string
   */
  private $string;

  /**
   * @param $string
   */
  function __construct($string) {
    $this->string = $string;
  }

  /**
   * @param string $token
   *
   * @return mixed
   * @throws SymbolParseException
   */
  protected function parseToken($token) {
    if ($this->string !== $token) {
      throw new SymbolParseException;
    }
    return $token;
  }
}
