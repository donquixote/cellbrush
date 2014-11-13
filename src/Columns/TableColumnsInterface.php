<?php

namespace Donquixote\Cellbrush\Columns;

/**
 * Partial interface for class Table.
 */
interface TableColumnsInterface {

  /**
   * @param string $colName
   *
   * @return $this
   *
   * @throws \Exception
   */
  function addColName($colName);

  /**
   * @param string[] $colNames
   *
   * @return $this
   */
  function addColNames(array $colNames);

  /**
   * @param string $groupName
   * @param string[] $colNameSuffixes
   *
   * @return $this
   *
   * @throws \Exception
   */
  function addColGroup($groupName, array $colNameSuffixes);

  /**
   * Sets the order for all columns or column groups at the top level, or at a
   * the relative top level within one group.
   *
   * @param string[] $orderedBaseColNames
   * @param string|null $groupPrefix
   *
   * @return $this
   *
   * @throws \Exception
   */
  function setColOrder($orderedBaseColNames, $groupPrefix = NULL);
}
