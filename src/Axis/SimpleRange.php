<?php

namespace Donquixote\Cellbrush\Axis;

class SimpleRange implements RangeInterface {

  /**
   * @var int
   */
  private $iMin;

  /**
   * @var int
   */
  private $iSup;

  /**
   * @var int
   */
  private $count;

  /**
   * @param int $iMin
   * @param int $iSup
   */
  function __construct($iMin, $iSup) {
    $this->iMin = $iMin;
    $this->iSup = $iSup;
    $this->count = $iSup - $iMin;
  }

  /**
   * @return int
   */
  function iMin() {
    return $this->iMin;
  }

  /**
   * @return int
   */
  function iSup() {
    return $this->iSup;
  }

  /**
   * @return int
   */
  function getCount() {
    return $this->count;
  }

  /**
   * @return int[]
   *   Format: [$iMin, $iSup]
   */
  function getMinSup() {
    return [$this->iMin, $this->iSup];
  }

  /**
   * @return static
   */
  public function getNext() {
    return new SimpleRange($this->iSup, $this->iSup + 1);
  }

  /**
   * @param int $iSup
   *
   * @return static
   */
  public function setSup($iSup) {
    $new = clone $this;
    $new->iSup = $iSup;
    return $new;
  }

  /**
   * @param int $span
   *
   * @return static
   */
  public function setSpan($span) {
    $new = clone $this;
    $new->iSup = $this->iMin + $span;
    return $new;
  }

  /**
   * @return int[]
   */
  public function getIndices() {
    return array_keys(array_fill($this->iMin, $this->count, true));
  }

  /**
   * @return int
   */
  public function iMax() {
    return $this->iSup - 1;
  }
}
