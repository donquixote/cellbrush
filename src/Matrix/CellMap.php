<?php

namespace Donquixote\Cellbrush\Matrix;

use Donquixote\Cellbrush\Cell\Cell;

/**
 * Collection of cells by row and col name, for one table section.
 */
class CellMap {

  /**
   * @var \Donquixote\Cellbrush\Cell\CellInterface[][]
   *   Format: $[$rowName][$colName] = $cell
   */
  private $cells = array();

  /**
   * @param string $rowName
   *   Row name or row group name.
   * @param string $colName
   *   Column name or column group name.
   * @param string $tagName
   *   Either 'td' or 'th'.
   * @param string $content
   *   HTML cell content.
   *
   * @throws \Exception
   */
  public function addCell($rowName, $colName, $tagName, $content) {
    $this->cells[$rowName][$colName] = new Cell($tagName, $content);
  }

  /**
   * @return \Donquixote\Cellbrush\Cell\CellInterface[][]
   *   Format: $[$rowName][$colName] = $cell
   */
  public function getCells() {
    return $this->cells;
  }
}
