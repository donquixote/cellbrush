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
    if (1 === $rowspan) {
      $colspan = null;
    }
    $this->rowspan = $rowspan;
    return $this->setAttribute('rowspan', $rowspan);
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
    if (1 === $colspan) {
      $colspan = null;
    }
    return $this->setAttribute('colspan', $colspan);
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
}
