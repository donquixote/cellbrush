<?php

namespace Donquixote\Cellbrush\Matrix;

class OpenEndMap {

  /**
   * A marker for cells that should be open-ended.
   *
   * @var true[][]
   *   Format: $[$rowName][$colName] = true
   */
  private $openEndCells = array();

  /**
   * @param string $rowName
   * @param string $colName
   */
  public function addCell($rowName, $colName) {
    $this->openEndCells[$rowName][$colName] = true;
  }

  /**
   * @return true[][]
   *   Format: $[$rowName][$colName] = true
   */
  public function getNames() {
    return $this->openEndCells;
  }
}
