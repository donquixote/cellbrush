<?php


namespace Donquixote\Cellbrush;


class TableColHandle extends SectionColHandle {

  /**
   * @var Table
   */
  private $table;

  /**
   * @param Table $table
   * @param TableSection $tbody
   * @param string $colName
   */
  function __construct($table, $tbody, $colName) {
    $this->table = $table;
    parent::__construct($tbody, $colName);
  }

  /**
   * @return SectionColHandle
   */
  function thead() {
    return new SectionColHandle($this->table->thead(), $this->colName);
  }

  /**
   * @return SectionColHandle
   */
  function tfoot() {
    return new SectionColHandle($this->table->tfoot(), $this->colName);
  }

  /**
   * @param string|null $sectionName
   *
   * @return SectionColHandle
   */
  function tbody($sectionName = NULL) {
    return new SectionColHandle($this->table->tbody($sectionName), $this->colName);
  }

} 
