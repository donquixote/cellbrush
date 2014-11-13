<?php

namespace Donquixote\Cellbrush\Html;

/**
 * @see MutableAttributesInterface
 */
trait MutableAttributesTrait {

  /**
   * Attribute values for all attributes except class.
   *
   * @var AttributesInterface
   */
  private $attributes;

  function __constructMutableAttributes() {
    $this->attributes = new Attributes();
  }

  /**
   * @param string $class
   *
   * @return $this
   */
  function addClass($class) {
    $this->attributes = $this->attributes->addClass($class);
    return $this;
  }

  /**
   * @param string[] $classes
   *
   * @return $this
   */
  function addClasses(array $classes) {
    $this->attributes = $this->attributes->addClasses($classes);
  }

  /**
   * @return string
   *   The string of all attributes, starting with a space.
   *   E.g. ' class="class0 class1" id="5"'
   */
  protected function renderAttributes() {
    return $this->attributes->renderAttributes();
  }

  /**
   * @param string $tagName
   * @param string $content
   *
   * @return string
   */
  protected function renderTag($tagName, $content) {
    return $this->attributes->renderTag($tagName, $content);
  }

  /**
   * @param $tagName
   *
   * @return TagInterface
   */
  protected function createTag($tagName) {
    return $this->attributes->createTag($tagName);
  }

}
