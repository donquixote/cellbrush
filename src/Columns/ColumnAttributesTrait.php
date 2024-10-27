<?php

namespace Donquixote\Cellbrush\Columns;

/**
 * @see ColumnAttributesInterface
 */
trait ColumnAttributesTrait {

  use ColumnClassesTrait;

  function __constructColumnAttributes() {
    $this->__constructColumnClasses();
  }

  /**
   * {@inheritdoc}
   */
  public function setColAttribute($colName, $name, $value) {
    $this->colAttributes->nameSetAttribute($colName, $name, $value);
    return $this;
  }

}
