<?php

namespace Donquixote\FlexiParser\Grammar\DoctrineAnnotation\Result;

class Annotation {

  /**
   * @var string
   */
  private $name;

  /**
   * @var array
   */
  private $settings;

  /**
   * @param string $name
   * @param array $settings
   */
  function __construct($name, array $settings) {
    $this->name = $name;
    $this->settings = $settings;
  }

} 
