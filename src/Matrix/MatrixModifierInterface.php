<?php
namespace Donquixote\Cellbrush\Matrix;

use Donquixote\Cellbrush\Axis\Axis;

/**
 * Interface for objects that build a matrix of cells.
 */
interface MatrixModifierInterface {

  /**
   * @param CellMatrix $matrix
   * @param Axis $rows
   * @param Axis $columns
   *
   * @return
   */
  public function modifyMatrix(CellMatrix $matrix, Axis $rows, Axis $columns);
}
