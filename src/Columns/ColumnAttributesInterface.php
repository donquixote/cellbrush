<?php

namespace Donquixote\Cellbrush\Columns;

interface ColumnAttributesInterface {

  /**
   * @param string $colName
   * @param string $name
   * @param string $value
   *
   * @return $this
   */
  public function setColAttribute($colName, $name, $value);

}
