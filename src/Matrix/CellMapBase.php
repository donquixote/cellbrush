<?php


namespace Donquixote\Cellbrush\Matrix;

use Donquixote\Cellbrush\Axis\Axis;

/**
 * Collection of cells by row and col name, for one table section.
 */
abstract class CellMapBase implements MatrixModifierInterface {

  /**
   * @param CellMatrix $matrix
   * @param \Donquixote\Cellbrush\Axis\Axis $rows
   * @param \Donquixote\Cellbrush\Axis\Axis $columns
   */
  public function modifyMatrix(CellMatrix $matrix, Axis $rows, Axis $columns) {

    // Fill the basic cells.
    foreach ($this->getCells() as $rowName => $rowCells) {
      $rowRange = $rows->subtreeRange($rowName);
      foreach ($rowCells as $colName => $cell) {
        $colRange = $columns->subtreeRange($colName);
        $brush = new RangedBrush($rowRange, $colRange);
        $matrix->addCell($brush, $cell);
      }
    }
  }

  /**
   * @return \Donquixote\Cellbrush\Cell\CellInterface[][]
   *   Format: $[$rowName][$colName] = $cell
   */
  abstract function getCells();

}
