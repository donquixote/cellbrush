<?php


namespace Donquixote\Cellbrush\Columns;

use Donquixote\Cellbrush\Html\Multiple\DynamicAttributesMap;

/**
 * @see ColumnClassesInterface
 */
trait ColumnClassesTrait {

  /**
   * Column classes for all table sections.
   *
   * @var DynamicAttributesMap
   */
  private $colAttributes;

  function __constructColumnClasses() {
    $this->colAttributes = new DynamicAttributesMap();
  }

  /**
   * @param string $colName
   * @param string $class
   *
   * @return $this
   */
  public function addColClass($colName, $class) {
    $this->colAttributes->nameAddClass($colName, $class);
    return $this;
  }

  /**
   * @param string[] $colClasses
   *   Format: $[$colName] = $class
   *
   * @return $this
   */
  function addColClasses(array $colClasses) {
    $this->colAttributes->namesAddClasses($colClasses);
    return $this;
  }

}
