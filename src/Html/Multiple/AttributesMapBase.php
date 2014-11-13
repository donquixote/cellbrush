<?php

namespace Donquixote\Cellbrush\Html\Multiple;

/**
 * Object representing attributes for a series of html elements.
 *
 * E.g. for all TR elements of a table section.
 */
class AttributesMapBase {

  /**
   * @var string[][]
   */
  protected $attributes = array();

  /**
   * @var string[][]
   */
  protected $classes = array();

  /**
   * @param string[][] $attributes
   * @param string[][] $classes
   *
   * @return static
   */
  public static function create(array $attributes, array $classes) {
    $new = new static;
    $new->attributes = $attributes;
    $new->classes = $classes;
    return $new;
  }

  /**
   * @param AttributesMapBase $source
   *
   * @return static
   */
  public static function createCopy(AttributesMapBase $source) {
    $new = new static;
    $new->attributes = $source->attributes;
    $new->classes = $source->classes;
    return $new;
  }

}
