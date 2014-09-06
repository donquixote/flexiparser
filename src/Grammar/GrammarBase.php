<?php

namespace Donquixote\FlexiParser\Grammar;

use Donquixote\FlexiParser\Symbol\SymbolInterface;

abstract class GrammarBase {

  /**
   * @var SymbolInterface[]
   */
  private $symbols = array();

  /**
   * @param string $key
   *
   * @return mixed
   *
   * @throws \Exception
   */
  public function __get($key) {
    if (isset($this->symbols[$key])) {
      return $this->symbols[$key];
    }
    $method = 'get_' . $key;
    return $this->symbols[$key] = $this->$method();
  }

} 
