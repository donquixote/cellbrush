<?php


namespace Donquixote\Cellbrush\Matrix;

use Donquixote\Cellbrush\Axis\RangeInterface;

class RangedBrush implements BrushInterface {

  /**
   * @var RangeInterface
   */
  private $rowRange;

  /**
   * @var RangeInterface
   */
  private $colRange;

  /**
   * @param RangeInterface $rowRange
   * @param RangeInterface $colRange
   */
  public function __construct(RangeInterface $rowRange, RangeInterface $colRange) {
    $this->rowRange = $rowRange;
    $this->colRange = $colRange;
  }

  /**
   * @return bool
   *   true, if the brush region is bigger than 1x1.
   */
  public function hasRange() {
    return true;
  }

  /**
   * @return int[]
   */
  public function getColIndices() {
    return $this->colRange->getIndices();
  }

  /**
   * @return int[]
   */
  public function getRowIndices() {
    return $this->rowRange->getIndices();
  }

  /**
   * @return int[]
   *   Format: [$iRow, $iCol]
   */
  public function getPosition() {
    return [$this->rowRange->iMin(), $this->colRange->iMin()];
  }

  /**
   * @return RangeInterface
   */
  public function getColRange() {
    return $this->colRange;
  }

  /**
   * @return RangeInterface
   */
  public function getRowRange() {
    return $this->rowRange;
  }

  /**
   * @return int
   */
  public function nRows() {
    return $this->rowRange->getCount();
  }

  /**
   * @return int
   */
  public function nCols() {
    return $this->colRange->getCount();
  }

  /**
   * @return BrushInterface
   */
  public function getNext() {
    $colRangeNext = $this->colRange->getNext();
    return $colRangeNext instanceof RangeInterface
      ? new self($this->rowRange, $colRangeNext)
      : null;
  }

  /**
   * @return int
   */
  public function iCol() {
    return $this->colRange->iMin();
  }

  /**
   * @return int
   */
  public function iRow() {
    return $this->rowRange->iMin();
  }

  /**
   * @param int $iColSup
   *
   * @return static
   */
  public function setColSup($iColSup) {
    $new = clone $this;
    $new->colRange = $new->colRange->setSup($iColSup);
    return $new;
}

  /**
   * @param int $colspan
   *
   * @return static
   */
  public function setColspan($colspan) {
    $new = clone $this;
    $new->colRange = $new->colRange->setSpan($colspan);
    return $new;
  }

  /**
   * @return int
   */
  public function iColSup() {
    return $this->colRange->iSup();
  }

  /**
   * @return int
   */
  public function iColMax() {
    return $this->colRange->iMax();
  }
}
