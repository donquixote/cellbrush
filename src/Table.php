<?php

namespace Donquixote\Cellbrush;

class Table extends TBodyWrapper {

  /**
   * @var TableColumns
   */
  private $columns;

  /**
   * @var TableSection
   */
  private $thead;

  /**
   * Additional tbody sections.
   * (The main tbody is in the protected $tbody variable of TBodyWrapper)
   *
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
    parent::__construct(new TableSection($this->columns));
    $this->tfoot = new TableSection($this->columns);
  }

  /**
   * @return self
   */
  static function create() {
    return new self();
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
   * @param string $class
   *
   * @return $this
   */
  function addColClass($colName, $class) {
    $this->columns->addColClass($colName, $class);
    return $this;
  }

  /**
   * @param string[] $colClasses
   *   Format: $[$colName] = $class
   *
   * @return $this
   */
  function addColClasses(array $colClasses) {
    $this->columns->addColClasses($colClasses);
    return $this;
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
      return parent::tbody();
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
   * A standardized way to access the main or only row of thead.
   *
   * @param string $rowName
   *
   * @return RowHandle
   */
  function headRow($rowName = 'head') {
    return $this->thead->addRowIfNotExists($rowName);
  }

  /**
   * @return string
   *   Rendered table html.
   */
  function render() {
    $html = '';
    $html .= $this->thead->render('thead');
    $html .= $this->tfoot->render('tfoot');
    $html .= parent::render();
    foreach ($this->tbodies as $tbody) {
      $html .= $tbody->render('tbody');
    }
    return '<table>' . "\n" . $html . '</table>' . "\n" ;
  }

}
