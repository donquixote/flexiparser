<?php


namespace Donquixote\FlexiParser\Symbol;


use Donquixote\FlexiParser\SymbolParseException;

class JsonPrimitive extends SingleTokenSymbolBase {

  /**
   * @param string $token
   *
   * @return mixed
   * @throws SymbolParseException
   */
  protected function parseToken($token) {
    $result = json_decode($token);
    if (!isset($result) && 'null' !== $token) {
      throw new SymbolParseException;
    }
    return $result;
  }
}
