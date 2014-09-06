<?php


namespace Donquixote\FlexiParser\Tokenizer;


class TokenIterator implements \Iterator {

  /**
   * The current index.
   *
   * @var int
   */
  private $index = 0;

  /**
   * @var TokenList
   */
  private $list;

  /**
   * @param TokenList $list
   */
  function __construct(TokenList $list) {
    $this->list = $list;
  }

  /**
   * @return string|null
   */
  function getToken() {
    return $this->list->getToken($this->index);
  }

  /**
   * @param bool $else
   *
   * @return bool
   */
  function hasSpaceBefore($else = TRUE) {
    return $this->list->spaceBeforeToken($this->index, $else);
  }

  /**
   * @param bool $else
   *
   * @return bool
   */
  function hasSpaceAfter($else = TRUE) {
    return $this->list->spaceAfterToken($this->index, $else);
  }

  /**
   * @return int
   */
  function getIndex() {
    return $this->index;
  }

  /**
   * Sets the index.
   *
   * This can be used to revert the iterator to a previous position after a
   * failure.
   *
   * @param int $index
   */
  function setIndex($index) {
    $this->index = $index;
  }

  /**
   * Returns the current element
   *
   * @link http://php.net/manual/en/iterator.current.php
   *
   * @return $this
   */
  public function current() {
    return $this;
  }

  /**
   * Moves forward to next element
   *
   * @link http://php.net/manual/en/iterator.next.php
   */
  public function next() {
    ++$this->index;
  }

  /**
   * Returns the key of the current element
   *
   * @link http://php.net/manual/en/iterator.key.php
   *
   * @return int
   */
  public function key() {
    return $this->index;
  }

  /**
   * Checks if current position is valid
   *
   * @link http://php.net/manual/en/iterator.valid.php
   *
   * @return bool
   */
  public function valid() {
    return $this->list->hasIndex($this->index);
  }

  /**
   * Rewinds the Iterator to the first element
   *
   * @link http://php.net/manual/en/iterator.rewind.php
   */
  public function rewind() {
    $this->index = 0;
  }

}
