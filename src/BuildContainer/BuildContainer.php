<?php

namespace Donquixote\Cellbrush\BuildContainer;

use Donquixote\Cellbrush\Axis\Axis;
use Donquixote\Cellbrush\Cell;
use Donquixote\Cellbrush\Cell\PlaceholderCell;
use Donquixote\Cellbrush\Html\Attributes;
use Donquixote\Cellbrush\Html\AttributesInterface;
use Donquixote\Cellbrush\Html\Multiple\StaticAttributesMap;
use Donquixote\Cellbrush\Matrix\CellMatrix;
use Donquixote\Cellbrush\Matrix\RangedBrush;

/**
 * @property Cell\CellInterface[][] NamedCells
 *   Named cells with classes applied.
 * @property int nRows
 * @property int nColumns
 * @property CellMatrix CellMatrix
 *   Object wrapping all cells.
 * @property Cell\CellInterface[][] MatrixCells
 *   All cells, with numeric indices.
 * @property string[] RowsInnerHtml
 *   Inner html of each table row, without the TR tags.
 * @property AttributesInterface[] IndexedRowAttributes
 * @property StaticAttributesMap IndexedColAttributes
 * @property StaticAttributesMap NamedColAttributes
 * @property mixed MatrixEmptyRow
 * @property string InnerHtml
 *   Inner html of the table section.
 */
class BuildContainer extends BuildContainerBase {

  /**
   * @var Axis
   */
  private $rows;

  /**
   * @var Axis
   */
  private $columns;

  /**
   * @param Axis $rows
   * @param Axis $columns
   */
  function __construct(Axis $rows, Axis $columns) {
    $this->rows = $rows;
    $this->columns = $columns;
    parent::__construct();
  }

  /**
   * @return StaticAttributesMap
   *
   * @see BuildContainer::$NamedColAttributes
   */
  protected function get_NamedColAttributes() {
    return $this->TableColAttributes->merge(
      $this->SectionColAttributes);
  }

  /**
   * @return StaticAttributesMap
   *
   * @see BuildContainer::$IndexedColAttributes
   */
  protected function get_IndexedColAttributes() {
    return $this->NamedColAttributes->transformNames(
      $this->columns->getLeafMap()
    );
  }

  /**
   * @return Cell\Cell[][]
   *
   * @see BuildContainer::$NamedCells
   */
  protected function get_NamedCells() {
    $cellContents = $this->CellContents;
    $cellTagNames = $this->CellTagNames;
    $cellClasses = $this->CellClasses;
    /** @var Cell\Cell[][] $namedCells */
    $namedCells = [];
    foreach ($cellContents as $rowName => $rowCellContents) {
      $rowCellTagNames = isset($cellTagNames[$rowName])
        ? $cellTagNames[$rowName]
        : [];
      $rowCellClasses = isset($cellClasses[$rowName])
        ? $cellClasses[$rowName]
        : [];
      $rowNamedCells = [];
      foreach ($rowCellContents as $colName => $cellContent) {
        $cellTagName = isset($rowCellTagNames[$colName])
          ? 'th'
          : 'td';
        $cell = new Cell\Cell($cellTagName, $cellContent);
        if (isset($rowCellClasses[$colName])) {
          $cell = $cell->addClasses($rowCellClasses[$colName]);
        }
        $rowNamedCells[$colName] = $cell;
      }
      $namedCells[$rowName] = $rowNamedCells;
    }
    foreach ($namedCells as $rowName => &$rowCells) {
      $this->NamedColAttributes->enhanceAttributes($rowCells);
    }
    return $namedCells;
  }

  /**
   * @return int
   *
   * @see BuildContainer::$nRows
   */
  protected function get_nRows() {
    return $this->rows->getCount();
  }

  /**
   * @return int
   *
   * @see BuildContainer::$nColumns
   */
  protected function get_nColumns() {
    return $this->columns->getCount();
  }

  /**
   * @return Cell\CellInterface[]
   * @see BuildContainer::$MatrixEmptyRow
   */
  protected function get_MatrixEmptyRow() {
    $emptyRow = $this->nColumns
      ? array_fill(0, $this->nColumns, new PlaceholderCell())
      : [];

    $this->IndexedColAttributes->enhanceAttributes($emptyRow);

    return $emptyRow;
  }

  /**
   * @return CellMatrix
   *
   * @see BuildContainer::$CellMatrix
   */
  protected function get_CellMatrix() {

    $matrix = new CellMatrix(
      $this->nRows,
      $this->MatrixEmptyRow);

    $cellClassesIndexed = [];
    foreach ($this->CellClasses as $rowName => $rowCellClasses) {
      if ($this->rows->nameIsLeaf($rowName)) {
        $iRow = $this->rows->subtreeIndex($rowName);
        $rowCellClassesIndexed = [];
        foreach ($rowCellClasses as $colName => $classes) {
          if ($this->columns->nameIsLeaf($colName)) {
            $iCol = $this->columns->subtreeIndex($colName);
            $rowCellClassesIndexed[$iCol] = $classes;
          }
        }
        $cellClassesIndexed[$iRow] = $rowCellClassesIndexed;
      }
    }

    $matrix->setCellClasses($cellClassesIndexed);

    foreach ($this->NamedCells as $rowName => $rowCells) {
      $rowRange = $this->rows->subtreeRange($rowName);
      foreach ($rowCells as $colName => $cell) {
        $colRange = $this->columns->subtreeRange($colName);
        $brush = new RangedBrush($rowRange, $colRange);
        $matrix->addCell($brush, $cell);
      }
    }

    foreach ($this->OpenEndCells as $rowName => $rowCells) {
      $rowRange = $this->rows->subtreeRange($rowName);
      foreach ($rowCells as $colName => $cTrue) {
        $colRange = $this->columns->subtreeRange($colName);
        $brush = new RangedBrush($rowRange, $colRange);
        $matrix->brushCellGrowRight($brush);
      }
    }

    return $matrix;
  }

  /**
   * @return Cell\CellInterface[][]
   * @see BuildContainer::$MatrixCells
   */
  protected function get_MatrixCells() {
    return $this->CellMatrix->getCells();
  }

  /**
   * @return string[]
   *
   * @see BuildContainer::$RowsInnerHtml
   */
  protected function get_RowsInnerHtml() {
    $rowsInnerHtml = [];
    foreach ($this->MatrixCells as $rowIndex => $rowCells) {
      $rowInnerHtml = '';
      foreach ($rowCells as $colIndex => $cell) {
        $rowInnerHtml .= $cell->render();
      }
      $rowsInnerHtml[$rowIndex] = $rowInnerHtml;
    }
    return $rowsInnerHtml;
  }

  /**
   * @return AttributesInterface[]
   *   Objects representing attributes for each TR element.
   * @see BuildContainer::$IndexedRowAttributes
   */
  protected function get_IndexedRowAttributes() {

    /** @var Attributes[] $all */
    $all = [];
    foreach ($this->rows->getLeafMap() as $rowName => $iRow) {
      $all[$iRow] = $this->RowAttributes->nameGetAttributes($rowName);
    }

    foreach ($this->RowStripings as $striping) {
      $n = count($striping);
      foreach ($all as $i => $attr) {
        if (isset($striping[$i % $n])) {
          $all[$i] = $attr->addClass($striping[$i % $n]);
        }
      }
    }

    return $all;
  }

  /**
   * @return string
   *
   * @see BuildContainer::$InnerHtml
   */
  protected function get_InnerHtml() {
    $innerHtml = '';
    $indexedRowAttributes = $this->IndexedRowAttributes;
    foreach ($this->RowsInnerHtml as $rowIndex => $rowInnerHtml) {
      if (isset($indexedRowAttributes[$rowIndex])) {
        $innerHtml .= '    ' . $indexedRowAttributes[$rowIndex]->renderTag('tr', $rowInnerHtml) . "\n";
      }
    }
    return $innerHtml;
  }
}
