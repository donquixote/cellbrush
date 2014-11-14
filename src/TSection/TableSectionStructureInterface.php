<?php

namespace Donquixote\Cellbrush\TSection;

/**
 * Interface for a table section, without TagAttributesInterface
 */
interface TableSectionStructureInterface extends TableRowsInterface {

  /**
   * @param string $colName
   *
   * @return \Donquixote\Cellbrush\Handle\SectionColHandle
   */
  function colHandle($colName);

  /**
   * @param string $rowName
   *
   * @return \Donquixote\Cellbrush\Handle\RowHandle
   * @throws \Exception
   */
  public function rowHandle($rowName);

  /**
   * Adds a row and returns the row handle.
   * This is a hybrid of addRowName() and rowHandle().
   *
   * @param $rowName
   *
   * @return \Donquixote\Cellbrush\Handle\RowHandle
   * @throws \Exception
   */
  public function addRow($rowName);

  /**
   * @param string $rowName
   * @param string $class
   *
   * @return $this
   */
  public function addRowClass($rowName, $class);

  /**
   * @param string[] $rowClasses
   *   Format: $[$rowName] = $class
   *
   * @return $this
   */
  public function addRowClasses(array $rowClasses);

  /**
   * @param string[] $striping
   *   Classes for striping. E.g. ['odd', 'even'], or '['1st', '2nd', '3rd'].
   *
   * @return $this
   */
  public function addRowStriping(array $striping = ['odd', 'even']);

  /**
   * @param string|string[] $rowName
   *   Row name, group or range.
   * @param string|string[] $colName
   *   Column name, group or range.
   * @param string $content
   *   HTML cell content.
   *
   * @return $this
   * @throws \Exception
   */
  function td($rowName, $colName, $content);

  /**
   * @param string|string[] $rowName
   *   Row name, group or range.
   * @param string|string[] $colName
   *   Column name, group or range.
   * @param string $content
   *   HTML cell content.
   *
   * @return $this
   * @throws \Exception
   */
  function th($rowName, $colName, $content);

  /**
   * Adds a td cell with a colspan that ends where the next known cell begins.
   *
   * @param string|string[] $rowName
   *   Row name, group or range.
   * @param string|string[] $colName
   *   Column name, group or range.
   * @param string $content
   *   HTML cell content.
   *
   * @return $this
   * @throws \Exception
   */
  function tdOpenEnd($rowName, $colName, $content);

  /**
   * Adds a th cell with a colspan that ends where the next known cell begins.
   *
   * @param string $rowName
   *   Row name, group or range.
   * @param string $colName
   *   Column name, group or range.
   * @param string $content
   *   HTML cell content.
   *
   * @return $this
   * @throws \Exception
   */
  function thOpenEnd($rowName, $colName, $content);

}
