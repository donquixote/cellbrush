<?php
namespace Donquixote\Cellbrush\Axis;

interface RangeInterface {

  /**
   * @return int
   */
  function iMin();

  /**
   * @return int
   */
  function iSup();

  /**
   * @return int
   */
  function getCount();

  /**
   * @return int[]
   *   Format: [$iMin, $iSup]
   */
  function getMinSup();

  /**
   * @return static|null
   */
  public function getNext();

  /**
   * @param int $iSup
   *
   * @return static
   */
  public function setSup($iSup);

  /**
   * @return int[]
   */
  public function getIndices();

  /**
   * @param int $span
   *
   * @return static
   */
  public function setSpan($span);

  /**
   * @return int
   */
  public function iMax();
}
