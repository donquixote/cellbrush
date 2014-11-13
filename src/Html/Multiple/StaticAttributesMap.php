<?php


namespace Donquixote\Cellbrush\Html\Multiple;

use Donquixote\Cellbrush\Html\Attributes;
use Donquixote\Cellbrush\Html\AttributesInterface;

/**
 * Object representing attributes for a series of html elements.
 *
 * E.g. for all TR elements of a table section.
 */
class StaticAttributesMap extends AttributesMapBase {

  /**
   * @param string $name

   *
*@return Attributes
   */
  public function nameGetAttributes($name) {
    return Attributes::create(
      isset($this->attributes[$name]) ? $this->attributes[$name] : [],
      isset($this->classes[$name]) ? $this->classes[$name] : []);
  }

  /**
   * @param AttributesInterface[] $rowCells
   */
  public function enhanceAttributes(array &$rowCells) {
    foreach ($this->classes as $name => $classes) {
      if (isset($rowCells[$name])) {
        $rowCells[$name] = $rowCells[$name]->addClasses($classes);
      }
    }
    // @todo Implement for attributes.
  }

  /**
   * @param StaticAttributesMap $otherMap
   *
   * @return StaticAttributesMap
   */
  public function merge(StaticAttributesMap $otherMap) {
    $new = clone $this;
    foreach ($otherMap->attributes as $name => $attributes) {
      $new->attributes[$name] += $attributes;
    }
    foreach ($otherMap->classes as $name => $classes) {
      $new->classes[$name] += $classes;
    }
    return $new;
  }

  /**
   * @param string[] $map
   *   Format: $[$oldName] = $newName
   *
   * @return StaticAttributesMap
   */
  public function transformNames(array $map) {
    $new = new StaticAttributesMap();
    foreach ($this->attributes as $name => $attributes) {
      if (isset($map[$name])) {
        $new->attributes[$map[$name]] = $attributes;
      }
    }
    foreach ($this->classes as $name => $classes) {
      if (isset($map[$name])) {
        $new->classes[$map[$name]] = $classes;
      }
    }
    return $new;
  }

}
