<?php

namespace Donquixote\Cellbrush\Columns;

use Donquixote\Cellbrush\Axis\DynamicAxis;

/**
 * @see TableColumnsInterface
 */
trait TableColumnsTrait {

  /**
   * @var DynamicAxis
   */
  private $columns;

  public function __constructTableColumns() {
    $this->columns = new DynamicAxis();
  }

  /**
   * @param string $colName
   *
   * @return $this
   * @throws \Exception
   */
  function addColName($colName) {
    $this->columns->addName($colName);
    return $this;
  }

  /**
   * @param string[] $colNames
   *
   * @return $this
   * @throws \Exception
   */
  function addColNames(array $colNames) {
    $this->columns->addNames($colNames);
    return $this;
  }

  /**
   * @param string $groupName
   * @param string[] $colNameSuffixes
   *
   * @return $this
   * @throws \Exception
   */
  function addColGroup($groupName, array $colNameSuffixes) {
    $this->columns->addGroup($groupName, $colNameSuffixes);
    return $this;
  }

  /**
   * Sets the order for all columns or column groups at the top level, or at a
   * the relative top level within one group.
   *
   * @param string[] $orderedBaseColNames
   * @param string|null $groupPrefix
   *
   * @return $this
   * @throws \Exception
   */
  function setColOrder($orderedBaseColNames, $groupPrefix = null) {
    $this->columns->setOrder($orderedBaseColNames, $groupPrefix);
    return $this;
  }

}
