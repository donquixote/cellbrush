<?php


namespace Donquixote\Cellbrush\Matrix;

use Donquixote\Cellbrush\Axis\RangeInterface;

class SimpleBrush implements BrushInterface {

  /**
   * @var int
   */
  private $iRow;

  /**
   * @var int
   */
  private $iCol;

  /**
   * @param int $iRow
   * @param int $iCol
   */
  function __construct($iRow, $iCol) {
    $this->iRow = $iRow;
    $this->iCol = $iCol;
  }

  /**
   * @return bool
   *   true, if the brush region is bigger than 1x1.
   */
  public function hasRange() {
    // TODO: Implement hasRange() method.
  }

  /**
   * @return int[]
   */
  public function getColIndices() {
    // TODO: Implement getColIndices() method.
  }

  /**
   * @return int[]
   */
  public function getRowIndices() {
    // TODO: Implement getRowIndices() method.
  }

  /**
   * @return int[]
   *   Format: [$iRow, $iCol]
   */
  public function getPosition() {
    // TODO: Implement getPosition() method.
  }

  /**
   * @return RangeInterface
   */
  public function getColRange() {
    // TODO: Implement getColRange() method.
  }

  /**
   * @return RangeInterface
   */
  public function getRowRange() {
    // TODO: Implement getRowRange() method.
  }

  /**
   * @return int
   */
  public function nRows() {
    // TODO: Implement nRows() method.
  }

  /**
   * @return int
   */
  public function nCols() {
    // TODO: Implement nCols() method.
  }

  /**
   * @return BrushInterface
   */
  public function getNext() {
    // TODO: Implement getNext() method.
  }

  /**
   * @return int
   */
  public function iCol() {
    // TODO: Implement iCol() method.
  }

  /**
   * @return int
   */
  public function iRow() {
    // TODO: Implement iRow() method.
  }

  /**
   * @param int $iColSup
   *
   * @return static
   */
  public function setColSup($iColSup) {
    // TODO: Implement setColSup() method.
  }

  /**
   * @param int $colspan
   *
   * @return static
   */
  public function setColspan($colspan) {
    // TODO: Implement setColspan() method.
  }

  /**
   * @return int
   */
  public function iColSup() {
    // TODO: Implement iColSup() method.
  }

  /**
   * @return int
   */
  public function iColMax() {
    // TODO: Implement iColMax() method.
}}
