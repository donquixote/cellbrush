<?php

namespace Donquixote\Cellbrush\Matrix;

use Donquixote\Cellbrush\Axis\RangeInterface;

interface BrushInterface {

  /**
   * @return bool
   *   true, if the brush region is bigger than 1x1.
   */
  public function hasRange();

  /**
   * @return int[]
   */
  public function getColIndices();

  /**
   * @return int[]
   */
  public function getRowIndices();

  /**
   * @return int[]
   *   Format: [$iRow, $iCol]
   */
  public function getPosition();

  /**
   * @return RangeInterface
   */
  public function getColRange();

  /**
   * @return RangeInterface
   */
  public function getRowRange();

  /**
   * @return int
   */
  public function nRows();

  /**
   * @return int
   */
  public function nCols();

  /**
   * @return BrushInterface
   */
  public function getNext();

  /**
   * @return int
   */
  public function iCol();

  /**
   * @return int
   */
  public function iRow();

  /**
   * @param int $iColSup
   *
   * @return static
   */
  public function setColSup($iColSup);

  /**
   * @param int $colspan
   *
   * @return static
   */
  public function setColspan($colspan);

  /**
   * @return int
   */
  public function iColSup();

  /**
   * @return int
   */
  public function iColMax();
}
