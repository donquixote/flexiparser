<?php


namespace Donquixote\FlexiParser\Tests;


use Donquixote\FlexiParser\Symbol\Concat;
use Donquixote\FlexiParser\Symbol\ExactString;
use Donquixote\FlexiParser\Symbol\OneOf;
use Donquixote\FlexiParser\Symbol\Regex;
use Donquixote\FlexiParser\Symbol\ConcatSentence;
use Donquixote\FlexiParser\Symbol\SeparatorRepeat;
use Donquixote\FlexiParser\Tokenizer\Tokenizer;
use Donquixote\FlexiParser\Util;

abstract class FlexiParserTest_ extends \PHPUnit_Framework_TestCase {

  function testParseFunctionCall() {
    $identifier = new Regex('#[A-Za-z_][A-Za-z0-9_]*#');
    $numeric = new Regex('#[0-9]+#');
    $arg = new OneOf(['numeric' => $numeric]);
    $arglist = new SeparatorRepeat($arg, new ExactString(','));
    $functionCall = new Concat(
      [
        'function' => $identifier,
        new ExactString('('),
        'args' => $arglist,
        new ExactString(')'),
      ]);
    $input = 'foo(125, 77)';
    $list = $this->getTokenizer()->tokenize($input);
    $result = $functionCall->parse($list->getIterator());

    $expected = array(
      'function' => array(
        'foo',
      ),
      0 => '(',
      'args' => array(
        array(
          'numeric',
          array(
            '125',
          ),
        ),
        array(
          'numeric',
          array(
            '77',
          ),
        ),
      ),
      1 => ')',
    );

    $this->assertEquals($expected, $result);
  }

  function _testRegex() {
    $arg = new Regex('#^(a|b|c)$#');
    $result = $arg->parse('b');
    var_dump($result);
  }

  function _testSimpleGrammar() {
    $arg = new Regex('#^(a|b|c)$#');
    $arg->parse('b');

    $arglist = new SeparatorRepeat($arg, ',');
    $identifier = new Regex('#^[a-zA-Z_][a-zA-Z0-9_]*$#');
    $functionCall = new ConcatSentence([$identifier, '(', $arglist, ')']);

    $input = 'foo(a, b, c)';
    $result = $functionCall->parse($input);
  }

  /**
   * @return \Donquixote\FlexiParser\Tokenizer\Tokenizer
   */
  private function getTokenizer() {
    return new Tokenizer(
      [
        '[a-z_\\\][a-z0-9_\:\\\]*[a-z_][a-z0-9_]*',
        '(?:[+-]?[0-9]+(?:[\.][0-9]+)*)(?:[eE][+-]?[0-9]+)?',
        '"(?:[^"]|"")*"',
      ],
      [
        '\s+',
        '\*+',
        '(.)',
      ]);
  }

} 
