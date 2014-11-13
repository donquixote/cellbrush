<?php

namespace Donquixote\Cellbrush\Columns;

interface ColumnClassesInterface {

  /**
   * @param string $colName
   * @param string $class
   *
   * @return $this
   */
  public function addColClass($colName, $class);

  /**
   * @param string[] $colClasses
   *   Format: $[$colName] = $class
   *
   * @return $this
   */
  function addColClasses(array $colClasses);

}
