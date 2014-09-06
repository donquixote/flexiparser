<?php


namespace Donquixote\FlexiParser\Tokenizer;


class Tokenizer {

  /**
   * @var string
   */
  private $regex;

  /**
   * @param string[] $catchablePatterns
   * @param string[] $nonCatchablePatterns
   */
  public function __construct(array $catchablePatterns, array $nonCatchablePatterns) {
    $this->regex = '/'
      . '(' . implode(')|(', $catchablePatterns) . ')'
      . '|'
      . implode('|', $nonCatchablePatterns)
      . '/i';
  }

  /**
   * Scans the input string for tokens.
   *
   * @param string $input
   *   Input string to be tokenized.
   *
   * @return TokenList
   */
  public function tokenize($input) {

    $matches = preg_split(
      $this->regex,
      $input,
      // No limit.
      -1,
      PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE);

    $endpos = 0;
    $tokens = [];
    $spacers = [];
    foreach ($matches as $match) {
      list($token, $pos) = $match;
      $tokens[] = $token;
      $spacers[] = ($pos !== $endpos);
      $endpos = $pos + strlen($token);
    }

    return new TokenList($tokens, $spacers);
  }

} 
