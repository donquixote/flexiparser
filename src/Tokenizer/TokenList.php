<?php


namespace Donquixote\FlexiParser\Tokenizer;


class TokenList implements \IteratorAggregate {

  /**
   * The token snippets
   *
   * @var string[]
   */
  private $tokens;

  /**
   * Whether each token is preceded by whitespace.
   *
   * @var bool[]
   */
  private $spaces;

  /**
   * @param string[] $tokens
   * @param bool[] $spaces
   */
  function __construct(array $tokens, array $spaces) {
    $this->tokens = $tokens;
    $this->spaces = $spaces;
  }

  /**
   * @return string[]
   */
  function getTokens() {
    return $this->tokens;
  }

  /**
   * @return bool[]
   */
  function getSpaces() {
    return $this->spaces;
  }

  /**
   * @param int $index
   *
   * @return string|null
   */
  function getToken($index) {
    return isset($this->tokens[$index])
      ? $this->tokens[$index]
      : null
      ;
  }

  /**
   * @param int $index
   * @param bool $else
   *
   * @return bool
   */
  function spaceBeforeToken($index, $else = true) {
    return isset($this->spaces[$index])
      ? $this->spaces[$index]
      : $else
      ;
  }

  /**
   * @param $index
   * @param bool $else
   *
   * @return bool
   */
  function spaceAfterToken($index, $else = true) {
    return isset($this->spaces[$index + 1])
      ? $this->spaces[$index + 1]
      : $else
      ;
  }

  /**
   * Retrieves an iterator to iterator over the tokens.
   *
   * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
   *
   * @return TokenIterator
   */
  public function getIterator() {
    return new TokenIterator($this);
  }

  /**
   * @param int $index
   *
   * @return bool
   */
  public function hasIndex($index) {
    return isset($this->tokens[$index]);
  }

}
