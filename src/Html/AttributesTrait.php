<?php

namespace Donquixote\Cellbrush\Html;

use Donquixote\Cellbrush\Util;

/**
 * @see ImmutableAttributesInterface
 * @see Attributes
 */
trait AttributesTrait {

  /**
   * Attribute values for all attributes except class.
   *
   * @var string[]
   *   Format: ['id' => 'theid']
   */
  private $attributes = array();

  /**
   * @var string[]
   *   Format: ['class0' => 'class0', 'class1' => 'class1', ..]
   */
  private $classes = array();

  /**
   * @param string[] $attributes
   * @param string[] $classes
   *
   * @return static
   */
  static function create($attributes, $classes) {
    $new = new static;
    $new->attributes = $attributes;
    $new->classes = array_combine($classes, $classes);
    return $new;
  }

  /**
   * @param string $class
   *
   * @return static
   */
  function addClass($class) {
    $clone = clone $this;
    $clone->classes[$class] = $class;
    return $clone;
  }

  /**
   * @param string[] $classes
   *
   * @return static
   */
  function addClasses(array $classes) {
    $clone = clone $this;
    foreach ($classes as $class) {
      $clone->classes[$class] = $class;
    }
    return $clone;
  }

  /**
   * @param string $key
   * @param string $value
   *
   * @return static
   */
  function setAttribute($key, $value) {
    if (isset($value)) {
      if (isset($this->attributes[$key]) && $value === $this->attributes[$key]) {
        // No change.
        return $this;
      }
      else {
        $clone = clone $this;
        $clone->attributes[$key] = $value;
        return $clone;
      }
    }
    else {
      if (!isset($this->attributes[$key])) {
        // No change.
        return $this;
      }
      else {
        $clone = clone $this;
        unset($clone->attributes[$key]);
        return $clone;
      }
    }
  }

  /**
   * @return string
   *   The string of all attributes, starting with a space.
   *   E.g. ' class="class0 class1" id="5"'
   */
  protected function renderAttributes() {
    $attributes = $this->attributes;
    if (!empty($this->classes)) {
      $attributes['class'] = implode(' ', $this->classes);
    }
    foreach ($attributes as $attribute => &$data) {
      $data = implode(' ', (array) $data);
      $data = $attribute . '="' . Util::checkPlain($data) . '"';
    }
    return $attributes ? ' ' . implode(' ', $attributes) : '';
  }

  /**
   * @param string $tagName
   * @param string $content
   *
   * @return string
   */
  protected function renderTag($tagName, $content) {
    return '<' . $tagName . $this->renderAttributes() . '>' . $content . '</' . $tagName . '>';
  }

  /**
   * @param $tagName
   *
   * @return TagInterface
   */
  protected function createTag($tagName) {
    $tag = new Tag($tagName);
    $tag->attributes = $this->attributes;
    $tag->classes = $this->classes;
    return $tag;
  }

  /**
   * @return string[]
   */
  public function getAttributes() {
    return $this->attributes;
  }

  /**
   * @return string[]
   */
  public function getClasses() {
    return $this->classes;
  }

  /**
   * @return bool
   *   true, if it has any attributes or classes.
   */
  public function hasAttributes() {
    return !empty($this->attributes) || !empty($this->classes);
  }

}
