<?php


namespace Donquixote\FlexiParser\Symbol;

use Donquixote\FlexiParser\SymbolParseException;

/**
 * Checks valid PHP identifiers.
 */
class Identifier extends SingleTokenSymbolBase {

  /**
   * @param string $token
   *
   * @return string
   * @throws SymbolParseException
   */
  function parseToken($token) {
    if (preg_match('#^[a-zA-Z_][a-zA-Z0-9_]*$#', $token, $m)) {
      return $m[0];
    }
    throw new SymbolParseException;
  }
}
