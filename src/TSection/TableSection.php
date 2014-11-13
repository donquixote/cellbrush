<?php

namespace Donquixote\Cellbrush\TSection;

use Donquixote\Cellbrush\Axis\Axis;
use Donquixote\Cellbrush\Axis\DynamicAxis;
use Donquixote\Cellbrush\BuildContainer\BuildContainer;
use Donquixote\Cellbrush\BuildContainer\BuildContainerBase;
use Donquixote\Cellbrush\Html\Multiple\DynamicAttributesMap;
use Donquixote\Cellbrush\Html\Multiple\StaticAttributesMap;
use Donquixote\Cellbrush\Html\MutableAttributesTrait;
use Donquixote\Cellbrush\Matrix\CellMap;
use Donquixote\Cellbrush\Matrix\OpenEndMap;
use Donquixote\Cellbrush\Handle\RowHandle;
use Donquixote\Cellbrush\Handle\SectionColHandle;


class TableSection implements TableSectionInterface {

  use MutableAttributesTrait;

  /**
   * @var string
   */
  private $tagName;

  /**
   * @var \Donquixote\Cellbrush\Axis\DynamicAxis
   */
  private $rows;

  /**
   * @var \Donquixote\Cellbrush\Html\Multiple\DynamicAttributesMap
   */
  private $rowAttributes;

  /**
   * @var CellMap
   */
  private $cellMap;

  /**
   * @var OpenEndMap
   */
  private $openEndMap;

  /**
   * @var string[][]
   *   Format: $[] = ['odd', 'even']
   */
  private $rowStripings = array();

  /**
   * Column classes for this table section.
   *
   * @var DynamicAttributesMap
   */
  private $colAttributes;

  /**
   * @param string $tagName
   */
  function __construct($tagName) {
    $this->__constructMutableAttributes();
    $this->tagName = $tagName;
    $this->rows = new DynamicAxis();
    $this->cellMap = new CellMap();
    $this->openEndMap = new OpenEndMap();
    $this->colAttributes = new DynamicAttributesMap();
    $this->rowAttributes = new DynamicAttributesMap();
  }

  /**
   * @param string $colName
   *
   * @return SectionColHandle
   * @throws \Exception
   */
  public function colHandle($colName) {
    return new SectionColHandle($this, $colName);
  }

  /**
   * Adds a column class for this table section.
   *
   * @param string $colName
   * @param string $class
   *
   * @return $this
   */
  public function addColClass($colName, $class) {
    $this->colAttributes->nameAddClass($colName, $class);
    return $this;
  }

  /**
   * Adds column classes for this table section.
   *
   * @param string[] $colClasses
   *   Format: $[$colName] = $class
   *
   * @return $this
   */
  public function addColClasses(array $colClasses) {
    $this->colAttributes->namesAddClasses($colClasses);
    return $this;
  }

  /**
   * @param string $rowName
   *
   * @return \Donquixote\Cellbrush\Handle\RowHandle
   * @throws \Exception
   */
  public function rowHandle($rowName) {
    if (!$this->rowExists($rowName)) {
      throw new \Exception("Row '$rowName' does not exist.");
    }
    return new RowHandle($this, $rowName);
  }

  /**
   * Adds a row and returns the row handle.
   * This is a hybrid of addRowName() and rowHandle().
   *
   * @param string $rowName
   *
   * @return RowHandle
   * @throws \Exception
   */
  public function addRow($rowName) {
    $this->addRowName($rowName);
    return new RowHandle($this, $rowName);
  }

  /**
   * @param string $rowName
   *
   * @return RowHandle
   */
  public function addRowIfNotExists($rowName) {
    $this->rows->addNameIfNotExists($rowName);
    return new RowHandle($this, $rowName);
  }

  /**
   * @param string $rowName
   * @param string $class
   *
   * @return $this
   */
  public function addRowClass($rowName, $class) {
    $this->rowAttributes->nameAddClass($rowName, $class);
    return $this;
  }

  /**
   * @param string[] $rowClasses
   *   Format: $[$rowName] = $class
   *
   * @return $this
   */
  public function addRowClasses(array $rowClasses) {
    $this->rowAttributes->namesAddClasses($rowClasses);
    return $this;
  }

  /**
   * @param string[] $striping
   *   Classes for striping. E.g. ['odd', 'even'], or '['1st', '2nd', '3rd'].
   *
   * @return $this
   */
  public function addRowStriping(array $striping = ['odd', 'even']) {
    $this->rowStripings[] = $striping;
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
    $this->cellMap->addCell($rowName, $colName, 'td', $content);
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
    $this->cellMap->addCell($rowName, $colName, 'th', $content);
    return $this;
  }

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
  function tdOpenEnd($rowName, $colName, $content) {
    $this->addOpenEndCell($rowName, $colName, 'td', $content);
    return $this;
  }

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
  function thOpenEnd($rowName, $colName, $content) {
    $this->addOpenEndCell($rowName, $colName, 'th', $content);
    return $this;
  }

  /**
   * @param string|string[] $rowName
   *   Row name, group or range.
   * @param string|string[] $colName
   *   Column name, group or range.
   * @param string $tagName
   *   Either 'td' or 'th'.
   * @param string $content
   *   HTML cell content.
   *
   * @throws \Exception
   */
  private function addOpenEndCell($rowName, $colName, $tagName, $content) {
    $this->cellMap->addCell($rowName, $colName, $tagName, $content);
    $this->openEndMap->addCell($rowName, $colName);
  }

  /**
   * @param Axis $columns
   *   Either 'thead' or 'tbody' or 'tfoot'.
   * @param StaticAttributesMap $tableColAttributes
   *
   * @return string
   *   Rendered table section html.
   */
  function render(Axis $columns, StaticAttributesMap $tableColAttributes) {

    if ($this->rows->isEmpty() || !$columns->getCount()) {
      return '';
    }

    $container = new BuildContainer(
      $this->rows->takeSnapshot(),
      $columns,
      $this->cellMap->getCells());

    /** @var BuildContainerBase $container */
    $container->OpenEndCells = $this->openEndMap->getNames();
    $container->RowAttributes = clone $this->rowAttributes->staticCopy();
    $container->RowStripings = $this->rowStripings;
    $container->TableColAttributes = $tableColAttributes;
    $container->SectionColAttributes = $this->colAttributes->staticCopy();

    /** @var BuildContainer $container */
    $innerHtml = $container->InnerHtml;

    return '  ' . $this->renderTag($this->tagName, "\n" . $innerHtml . '  ') . "\n";
  }

  /**
   * @param string $groupName
   * @param string[] $rowNameSuffixes
   *
   * @return $this
   * @throws \Exception
   */
  public function addRowGroup($groupName, $rowNameSuffixes) {
    $this->rows->addGroup($groupName, $rowNameSuffixes);
    return $this;
  }

  /**
   * @param string $rowName
   *
   * @return $this
   * @throws \Exception
   */
  function addRowName($rowName) {
    $this->rows->addName($rowName);
    return $this;
  }

  /**
   * @param string[] $rowNames
   *
   * @return $this
   */
  function addRowNames(array $rowNames) {
    $this->rows->addNames($rowNames);
    return $this;
  }

  /**
   * @param string $rowName
   *
   * @return true
   */
  function rowExists($rowName) {
    return $this->rows->nameExists($rowName);
  }
}
