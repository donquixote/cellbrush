<?php

namespace Donquixote\Cellbrush\Cell;

use Donquixote\Cellbrush\Html\Element;

class Cell extends Element implements CellInterface {

  /**
   * @var int
   */
  private $rowspan = 1;

  /**
   * @var int
   */
  private $colspan = 1;

  /**
   * @param int $rowspan
   *
   * @return static
   */
  function setRowspan($rowspan) {
    if ($rowspan === $this->rowspan) {
      // Nothing to do.
      return $this;
    }
    $clone = $this->setAttribute('rowspan', $rowspan > 1 ? $rowspan : null);
    $clone->rowspan = $rowspan;
    return $clone;
  }

  /**
   * @param int $colspan
   *
   * @return static
   */
  function setColspan($colspan) {
    if ($colspan === $this->colspan) {
      // Nothing to do.
      return $this;
    }
    $clone = $this->setAttribute('colspan', $colspan > 1 ? $colspan : null);
    $clone->colspan = $colspan;
    return $clone;
  }

  /**
   * @return int
   */
  public function getRowspan() {
    return $this->rowspan;
  }

  /**
   * @return int
   */
  public function getColspan() {
    return $this->colspan;
  }

  /**
   * @return bool
   *   true, if rowspan > 1 or colspan > 1.
   */
  public function hasRange() {
    return $this->rowspan > 1 && $this->colspan > 1;
  }
}
