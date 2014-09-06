<?php


namespace Donquixote\FlexiParser;


class Util {

  /**
   * @param $docComment
   *
   * @return bool|string
   */
  static function peelDocComment($docComment) {
    if ('/**' !== substr($docComment, 0, 3)) {
      return false;
    }
    if ('*/' !== substr($docComment, -2)) {
      return false;
    }
    $peeled = substr($docComment, 3, -2);
    $lines = explode("\n", $peeled);
    $firstline = array_shift($lines);
    if ('' !== rtrim($firstline)) {
      return false;
    }
    $lastline = array_pop($lines);
    if ('' !== rtrim($lastline)) {
      return false;
    }
    foreach ($lines as &$line) {
      $line = trim($line);
      if ('' === $line) {
        return false;
      }
      if ('*' !== $line{0}) {
        // We require every line to begin with '*', optionally with some space
        // before.
        return false;
      }
      $line = substr($line, 1);
    }
    return implode("\n", $lines);
  }

  /**
   * @param mixed $data
   *
   * @return string
   */
  static function niceExport($data) {
    if (0
      || !is_array($data)
      || empty($data)
    ) {
      $result = var_export($data, true);
    }
    elseif (array_values($data) === $data) {
      $result = self::niceExportArrayValues($data);
    }
    else {
      $result = self::niceExportArrayAssoc($data);
    }

    return $result;
  }

  /**
   * @param array $values
   *
   * @return string
   */
  private static function niceExportArrayValues(array $values) {
    $export = array_map(
      function($value) {
        $result = self::niceExport($value);
        return str_replace("\n", "\n  ", $result);
      },
      $values);

    return "array(\n  " . implode(",\n  ", $export) . ",\n)";
  }

  /**
   * @param array $data
   *
   * @return string
   */
  private static function niceExportArrayAssoc(array $data) {
    $export = array_map(
      function($key) use ($data) {
        $value = $data[$key];
        $result = var_export($key, true) . ' => ' . self::niceExport($value);
        return str_replace("\n", "\n  ", $result);
      },
      array_keys($data));

    return "array(\n  " . implode(",\n  ", $export) . ",\n)";
  }

} 
