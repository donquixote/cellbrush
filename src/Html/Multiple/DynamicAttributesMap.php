<?php


namespace Donquixote\Cellbrush\Html\Multiple;

/**
 * Object representing attributes for a series of html elements.
 *
 * E.g. for all TR elements of a table section.
 */
class DynamicAttributesMap extends AttributesMapBase {

  /**
   * @return StaticAttributesMap
   */
  public function staticCopy() {
    return StaticAttributesMap::createCopy($this);
  }

  /**
   * @param string $name
   * @param string $class
   */
  public function nameAddClass($name, $class) {
    $this->classes[$name][$class] = $class;
  }

  /**
   * @param string $name
   * @param string[] $classes
   */
  public function nameAddClasses($name, $classes) {
    foreach ($classes as $class) {
      $this->classes[$name][$class] = $class;
    }
  }

  /**
   * @param string[] $namesClasses
   *   Format: $[$name] = $class
   *
   * @return $this
   */
  public function namesAddClasses(array $namesClasses) {
    foreach ($namesClasses as $name => $class) {
      $this->classes[$name][$class] = $class;
    }
  }

  /**
   * @param string $name
   * @param string $key
   * @param string $value
   */
  public function nameSetAttribute($name, $key, $value) {
    $this->attributes[$name][$key] = $value;
  }

}
