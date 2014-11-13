<?php


namespace Donquixote\Cellbrush\Matrix;

class ColClasses extends CellMapBase {

  /**
   * @var CellMapBase
   */
  private $decorated;

  /**
   * Column classes for this table section.
   *
   * @var string[][]
   *   Format: $[$rowName][] = $class
   */
  private $colClasses = array();

  /**
   * Adds a column class for this table section.
   *
   * @param string $colName
   * @param string $class
   *
   * @return $this
   */
  public function addColClass($colName, $class) {
    $this->colClasses[$colName][] = $class;
  }

  /**
   * Adds column classes for this table section.
   *
   * @param string[] $colClasses
   *   Format: $[$colName] = $class
   *
   * @return $this
   */
  public function addColClasses(array $colClasses) {
    foreach ($colClasses as $colName => $class) {
      $this->colClasses[$colName][] = $class;
    }
    return $this;
  }

  /**
   * @return \Donquixote\Cellbrush\Cell\CellInterface[][]
   *   Format: $[$rowName][$colName] = $cell
   */
  function getCells() {
    $cells = $this->decorated->getCells();
    foreach ($this->colClasses as $colName => $classes) {
      /** @var \Donquixote\Cellbrush\Cell\CellInterface[] $rowCells */
      foreach ($cells as $rowCells) {
        if (isset($rowCells[$colName])) {
          $rowCells[$colName] = $rowCells[$colName]->addClasses($classes);
        }
      }
    }
  }
}
