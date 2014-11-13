<?php

namespace Donquixote\Cellbrush\Html;


use Donquixote\Cellbrush\Util;

trait TagAttributesTrait {

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
   * @param string $class
   *
   * @return $this
   */
  function addClass($class) {
    $this->classes[$class] = $class;
    return $this;
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

}
