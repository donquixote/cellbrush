<?php

namespace Donquixote\Cellbrush\Cell;

/**
 * Pseudo-cell in the shadow of a rowspan or colspan.
 */
class ShadowCell implements CellInterface {

  /**
   * @param string $class
   *
   * @return static
   */
  function addClass($class) {
    // Do nothing.
    return $this;
  }

  /**
   * @param string[] $classes
   *
   * @return static
   */
  function addClasses(array $classes) {
    // Do nothing.
    return $this;
  }

  /**
   * @param int $rowspan
   *
   * @return static
   *   A modified clone of this value object.
   */
  function setRowspan($rowspan) {
    throw new \RuntimeException("Cannot set rowspan of shadow cell.");
  }

  /**
   * @param int $colspan
   *
   * @return static
   *   A modified clone of this value object.
   */
  function setColspan($colspan) {
    throw new \RuntimeException("Cannot set rowspan of shadow cell.");
  }

  /**
   * @return string
   */
  function render() {
    // Shadow cells are skipped.
    return '';
  }

  /**
   * @return int
   */
  public function getRowspan() {
    return 1;
  }

  /**
   * @return int
   */
  public function getColspan() {
    return 1;
  }

  /**
   * @return bool
   *   true, if rowspan > 1 or colspan > 1.
   */
  public function hasRange() {
    return false;
  }
}
