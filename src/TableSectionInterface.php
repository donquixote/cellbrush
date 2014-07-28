<?php
/**
 * Created by PhpStorm.
 * User: lemonhead
 * Date: 7/28/14
 * Time: 9:00 PM
 */

namespace Donquixote\Cellbrush;

/**
 * Wrapper/decorator for a tbody element.
 */
interface TableSectionInterface {

  /**
   * @param string $colName
   *
   * @return SectionColHandle
   */
  function colHandle($colName);

  /**
   * @param string $rowName
   *
   * @return $this
   * @throws \Exception
   */
  function addRowName($rowName);

  /**
   * @param string[] $rowNames
   *
   * @return $this
   */
  function addRowNames(array $rowNames);

  /**
   * @param string $groupName
   * @param string[] $rowNameSuffixes
   *
   * @return $this
   * @throws \Exception
   */
  function addRowGroup($groupName, array $rowNameSuffixes);

  /**
   * @param string $rowName
   *
   * @return RowHandle
   * @throws \Exception
   */
  public function rowHandle($rowName);

  /**
   * Adds a row and returns the row handle.
   * This is a hybrid of addRowName() and rowHandle().
   *
   * @param $rowName
   *
   * @return RowHandle
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

} 
