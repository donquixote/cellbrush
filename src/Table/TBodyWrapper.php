<?php

namespace Donquixote\Cellbrush\Table;

use Donquixote\Cellbrush\Axis\Axis;
use Donquixote\Cellbrush\Html\Multiple\StaticAttributesMap;
use Donquixote\Cellbrush\TSection\TableSection;
use Donquixote\Cellbrush\TSection\TableSectionStructureInterface;

/**
 * Wrapper/decorator for a tbody element.
 */
class TBodyWrapper implements TableSectionStructureInterface {

  /**
   * @var \Donquixote\Cellbrush\TSection\TableSection
   */
  private $tbody;

  /**
   * The constructor.
   *
   * @param \Donquixote\Cellbrush\TSection\TableSection $tbody
   */
  function __construct(TableSection $tbody) {
    $this->tbody = $tbody;
  }

  /**
   * @return \Donquixote\Cellbrush\TSection\TableSection
   */
  function tbody() {
    return $this->tbody;
  }

  /**
   * @param string $colName
   *
   * @return \Donquixote\Cellbrush\Handle\SectionColHandle
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
   * @return \Donquixote\Cellbrush\Handle\RowHandle
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
   * @return \Donquixote\Cellbrush\Handle\RowHandle
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
   * @param Axis $columns
   * @param StaticAttributesMap $tableColAttributes
   *
   * @return string
   */
  function render(Axis $columns, StaticAttributesMap $tableColAttributes) {
    return $this->tbody->render($columns, $tableColAttributes);
  }

  /**
   * @param string $rowName
   *
   * @return true
   */
  function rowExists($rowName) {
    return $this->tbody->rowExists($rowName);
  }
}
