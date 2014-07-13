<?php

namespace Donquixote\Cellbrush;

class Table {

  /**
   * @var TableColumns
   */
  private $columns;

  /**
   * @var TableSection
   */
  private $thead;

  /**
   * @var TableSection
   */
  private $tbody;

  /**
   * @var TableSection[]
   */
  private $tbodies = array();

  /**
   * @var TableSection
   */
  private $tfoot;

  /**
   * The constructor.
   */
  function __construct() {
    $this->columns = new TableColumns();
    $this->thead = new TableSection($this->columns);
    $this->tbody = new TableSection($this->columns);
    $this->tfoot = new TableSection($this->columns);
  }

  /**
   * @param string $colName
   *
   * @return $this
   * @throws \Exception
   */
  function addColName($colName) {
    $this->columns->addColname($colName);
    return $this;
  }

  /**
   * @param string[] $colNames
   *
   * @return $this
   * @throws \Exception
   */
  function addColNames($colNames) {
    $this->columns->addColnames($colNames);
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
    $this->columns->addColGroup($groupName, $colNameSuffixes);
    return $this;
  }

  /**
   * @param string $colName
   *
   * @return SectionColHandle
   */
  function colHandle($colName) {
    $this->columns->verifyColName($colName);
    return new TableColHandle($this, $this->tbody, $colName);
  }

  /**
   * @return TableSection
   */
  function thead() {
    return $this->thead;
  }

  /**
   * @param string|null $name
   *   Key to identify the tbody, if another than the main tbody is used.
   *
   * @return TableSection
   */
  function tbody($name = NULL) {
    if (!isset($name)) {
      return $this->tbody;
    }
    return isset($this->tbodies[$name])
      ? $this->tbodies[$name]
      : $this->tbodies[$name] = new TableSection($this->columns);
  }

  /**
   * @return TableSection
   */
  function tfoot() {
    return $this->tfoot;
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
   *   Rendered table html.
   */
  function render() {
    $html = '';
    $html .= $this->thead->render('thead');
    $html .= $this->tfoot->render('tfoot');
    $html .= $this->tbody->render('tbody');
    foreach ($this->tbodies as $tbody) {
      $html .= $tbody->render('tbody');
    }
    return '<table>' . "\n" . $html . '</table>' . "\n" ;
  }

} 
