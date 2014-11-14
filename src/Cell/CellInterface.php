<?php

namespace Donquixote\Cellbrush\Cell;

use Donquixote\Cellbrush\Html\ElementInterface;

interface CellInterface extends ElementInterface {

  /**
   * @param int $rowspan
   *
   * @return static
   *   A modified clone of this value object.
   */
  function setRowspan($rowspan);

  /**
   * @param int $colspan
   *
   * @return static
   *   A modified clone of this value object.
   */
  function setColspan($colspan);

  /**
   * @return int
   */
  public function getRowspan();

  /**
   * @return int
   */
  public function getColspan();

  /**
   * @return bool
   *   true, if rowspan > 1 or colspan > 1.
   */
  public function hasRange();

}
