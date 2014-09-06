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

abstract class TokenizerTest extends \PHPUnit_Framework_TestCase {

  function testPeelDocComment() {
    $docComment = <<<'EOT'
/**
 * Plugin implementation of the 'link' formatter.
 *
 * @FieldFormatter(
 *   id = "link",
 *   label = @Translation("Link"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
EOT;

    $expected = <<<'EOT'
 Plugin implementation of the 'link' formatter.

 @FieldFormatter(
   id = "link",
   label = @Translation("Link"),
   field_types = {
     "link"
   }
 )
EOT;

    $peeled = Util::peelDocComment($docComment);
    $this->assertEquals($expected, $peeled);
  }

  function testTokenize() {
    $tokenizer = $this->getTokenizer();
    $input = <<<'EOT'
 Plugin implementation of the 'link' formatter.

 @FieldFormatter(
   id = "link",
   label = @Translation("Link"),
   field_types = {
     "link"
   }
 )
EOT;

    $list = $tokenizer->tokenize($input);

    $this->assertEquals(
      [
        'Plugin', 'implementation', 'of', 'the', '\'', 'link', '\'', 'formatter',
        '.', '@', 'FieldFormatter', '(', 'id', '=', '"link"', ',', 'label', '=',
        '@', 'Translation', '(', '"Link"', ')', ',', 'field_types', '=', '{',
        '"link"', '}', ')'
      ],
      $list->getTokens());

    $this->assertEquals(
      [0, 1, 2, 3, 4, 7, 9, 12, 13, 14, 16, 17, 18, 24, 25, 26, 27, 28, 29],
      array_keys(array_filter($list->getSpaces())));
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
