<?php


namespace Donquixote\FlexiParser\Tests;


use Donquixote\FlexiParser\Grammar\DoctrineAnnotation\DoctrineAnnotationGrammar;
use Donquixote\FlexiParser\Symbol\Concat;
use Donquixote\FlexiParser\Symbol\ExactString;
use Donquixote\FlexiParser\Symbol\JsonPrimitive;
use Donquixote\FlexiParser\SymbolParseException;
use Donquixote\FlexiParser\Tokenizer\Tokenizer;
use Donquixote\FlexiParser\Util;

class DoctrineAnnotationTest extends \PHPUnit_Framework_TestCase {

  function testAnnotationSettings() {
    $list = $this->getTokenizer()->tokenize('foo="bar", xx = -5.6, uu = zz, 66');
    # print Util::niceExport($list->getTokens());
    $grammar = new DoctrineAnnotationGrammar();
    $result = $grammar->annotationSettings->parse($list->getIterator());

    $expected = [
      'foo' => 'bar',
      'xx' => -5.5999999999999996,
    ];

    $this->assertEquals($expected, $result);
  }

  function testConcatFail() {
    $list = $this->getTokenizer()->tokenize('("a"');
    $concat = new Concat(
      [
        new ExactString('('),
        new JsonPrimitive(),
        new ExactString(')'),
      ]);
    try {
      $result = $concat->parse($list->getIterator());
    }
    catch (SymbolParseException $e) {
      $this->assertTrue(true, 'SymbolParseException was thrown as expected.');
      return;
    }
    $this->fail('SymbolParseException was not thrown.');
  }

  function testAnnotation() {
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
    $list = $this->tokenizeDocComment($docComment);
    $grammar = new DoctrineAnnotationGrammar();
    $result = $grammar->commentWithAnnotations->parse($list->getIterator());
    print_r($result);
    # print Util::niceExport($result);
  }

  /**
   * @param string $docComment
   *
   * @return \Donquixote\FlexiParser\Tokenizer\TokenList
   */
  private function tokenizeDocComment($docComment) {
    $input = Util::peelDocComment($docComment);
    return $this->getTokenizer()->tokenize($input);
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
