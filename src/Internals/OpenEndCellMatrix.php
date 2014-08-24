<?php

namespace Donquixote\Cellbrush\Internals;


class OpenEndCellMatrix {

  /**
   * Positions of open-end cells with colspan.
   *
   * @var true[][]
   *   Format: $[$rowName][$colName] = true.
   */
  private $openEndRight = [];

  /**
   * Positions of open-end cells with rowspan.
   *
   * @var true[][]
   *   Format: $[$rowName][$colName] = true.
   */
  private $openEndDown = [];

  /**
   * @param string $rowName
   * @param string $colName
   */
  function markOpenEndRight($rowName, $colName) {
    $this->openEndRight[$rowName][$colName] = true;
  }

  function markOpenEndDown($rowName, $colName) {
    $this->openEndDown[$rowName][$colName] = true;
  }

} 
