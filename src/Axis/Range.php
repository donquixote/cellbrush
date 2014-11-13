<?php


namespace Donquixote\Cellbrush\Axis;

class Range extends SimpleRange {

  /**
   * @var Axis
   */
  private $axis;

  /**
   * @var string
   */
  private $name;

  /**
   * @param int $iMin
   * @param int $iSup
   * @param string $name
   * @param Axis $axis
   */
  function __construct($iMin, $iSup, $name, Axis $axis) {
    parent::__construct($iMin, $iSup);
    $this->name = $name;
    $this->axis = $axis;
  }

  /**
   * @return static
   */
  public function getNext() {
    $nextName = $this->axis->nameGetNextName($this->name);
    return isset($nextName)
      ? $this->axis->subtreeRange($nextName)
      : null;
  }
}
