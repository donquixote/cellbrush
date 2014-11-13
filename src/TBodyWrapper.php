<?php

namespace Donquixote\Cellbrush;

/**
 * Wrapper/decorator for a tbody element.
 */
class TBodyWrapper implements TableSectionInterface {

  /**
   * @var TableSection
   */
  private $tbody;

  /**
   * The constructor.
   *
   * @param \Donquixote\Cellbrush\TableSection $tbody
   */
  function __construct(TableSection $tbody) {
    $this->tbody = $tbody;
  }

  /**
   * @return TableSection
   */
  function tbody() {
    return $this->tbody;
  }

  /**
   * @param string $colName
   *
   * @return SectionColHandle
   */
  function colHandle($colName) {
    return $this->tbody->colHandle($colName);
  }

  /**
   * @param string $rowName
   *
   * @return $this
   * @throws \Exception
   */
  function addRowName($rowName) {
    $this->tbody->addRowName($rowName);
    return $this;
  }

  /**
   * @param string[] $rowNames
   *
   * @return $this
   */
  function addRowNames(array $rowNames) {
    $this->tbody->addRowNames($rowNames);
    return $this;
  }

  /**
   * @param string $groupName
   * @param string[] $rowNameSuffixes
   *
   * @return $this
   * @throws \Exception
   */
  function addRowGroup($groupName, array $rowNameSuffixes) {
    $this->tbody->addRowGroup($groupName, $rowNameSuffixes);
    return $this;
  }

  /**
   * @param string $rowName
   *
   * @return RowHandle
   * @throws \Exception
   */
  public function rowHandle($rowName) {
    return $this->tbody->rowHandle($rowName);
  }

  /**
   * Adds a row and returns the row handle.
   * This is a hybrid of addRowName() and rowHandle().
   *
   * @param $rowName
   *
   * @return RowHandle
   * @throws \Exception
   */
  public function addRow($rowName) {
    return $this->tbody->addRow($rowName);
  }

  /**
   * @param string $rowName
   * @param string $class
   *
   * @return $this
   */
  public function addRowClass($rowName, $class) {
    $this->tbody->addRowClass($rowName, $class);
    return $this;
  }

  /**
   * @param string[] $rowClasses
   *   Format: $[$rowName] = $class
   *
   * @return $this
   */
  public function addRowClasses(array $rowClasses) {
    $this->tbody->addRowClasses($rowClasses);
    return $this;
  }

  /**
   * @param string[] $striping
   *   Classes for striping. E.g. ['odd', 'even'], or '['1st', '2nd', '3rd'].
   *
   * @return $this
   */
  public function addRowStriping(array $striping = ['odd', 'even']) {
    $this->tbody->addRowStriping($striping);
    return $this;
  }

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
  function td($rowName, $colName, $content) {
    $this->tbody->td($rowName, $colName, $content);
    return $this;
  }

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
  function th($rowName, $colName, $content) {
    $this->tbody->th($rowName, $colName, $content);
    return $this;
  }

  /**
   * @return string
   */
  function render() {
    return $this->tbody->render('tbody');
  }

  /**
   * @param string $class
   *
   * @return $this
   */
  function addClass($class) {
    $this->tbody->addClass($class);
    return $this;
  }

}
