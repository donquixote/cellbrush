<?php

namespace Donquixote\Cellbrush\Matrix;

use Donquixote\Cellbrush\Cell\CellInterface;
use Donquixote\Cellbrush\Cell\PlaceholderCell;
use Donquixote\Cellbrush\Cell\ShadowCell;

/**
 * Matrix of table cells by index.
 */
class CellMatrix {

  /**
   * @var ShadowCell
   */
  private $shadowCell;

  /**
   * @var CellInterface[][]
   *   Format: $[$rowIndex][$colIndex] = new TableCell(..)
   */
  private $cells;

  /**
   * @param int $nRows
   * @param int $nColumns
   *
   * @return static
   */
  public static function create($nRows, $nColumns) {
    $emptyRow = $nColumns
      ? array_fill(0, $nColumns, new PlaceholderCell())
      : [];
    return new static($nRows, $emptyRow);
  }

  /**
   * @param int $nRows
   * @param CellInterface[] $emptyRow
   */
  public function __construct($nRows, array $emptyRow) {
    $this->shadowCell = new ShadowCell();
    // Create an empty n*m matrix.
    $this->cells = $nRows
      ? array_fill(0, $nRows, $emptyRow)
      : [];
  }

  /**
   * @param int $iRow
   * @param int $iCol
   * @param \Donquixote\Cellbrush\Cell\CellInterface $cell
   */
  public function addCell($iRow, $iCol, CellInterface $cell) {
    if ($cell->hasRange()) {
      $this->paintShadow($iRow, $iCol, $iRow + $cell->getRowspan(), $iCol + $cell->getColspan());
    }
    else {
      // @todo Check for collision.
    }
    $this->cells[$iRow][$iCol] = $cell;
  }

  /**
   * @param int $iRow
   * @param int $iCol
   * @param int $iColSup
   *
   * @return bool
   *   true, if the growing was successful.
   * @throws \Exception
   */
  public function cellGrowRight($iRow, $iCol, $iColSup) {
    if (!isset($this->cells[$iRow][$iCol])) {
      throw new \RuntimeException('No cell at this position.');
    }
    $cell = $this->cells[$iRow][$iCol];
    if ($cell instanceof ShadowCell) {
      throw new \Exception("Can't grow a ShadowCell.");
    }
    if ($cell instanceof PlaceholderCell) {
      throw new \Exception("Can't grow a PlaceholderCell.");
    }
    // Coordinates of the extension area on the right of the cell.
    $iRowMin = $iRow;
    $iRowSup = $iRow + $cell->getRowspan();
    $iColMin = $iCol + $cell->getColspan();
    if (!$this->areaIsFree($iRowMin, $iColMin, $iRowSup, $iColSup)) {
      return false;
    }
    $this->paintShadow($iRowMin, $iColMin, $iRowSup, $iColSup);
    $this->cells[$iRow][$iCol] = $cell->setColspan($iColSup - $iCol);
    return true;
  }

  /**
   * @param int $iRowMin
   * @param int $iColMin
   * @param int $iRowSup
   * @param int $iColSup
   *
   * @return bool
   *   true, if the area is free.
   */
  private function areaIsFree($iRowMin, $iColMin, $iRowSup, $iColSup) {
    for ($iRow = $iRowMin; $iRow < $iRowSup; ++$iRow) {
      if (!isset($this->cells[$iRow])) {
        return false;
      }
      $rowCells =& $this->cells[$iRow];
      for ($iCol = $iColMin; $iCol < $iColSup; ++$iCol) {
        if (!isset($rowCells[$iCol])) {
          return false;
        }
        if (!$rowCells[$iCol] instanceof PlaceholderCell) {
          return false;
        }
      }
    }
    return true;
  }

  /**
   * @param int $iRowMin
   * @param int $iColMin
   * @param int $iRowSup
   * @param int $iColSup
   */
  private function paintShadow($iRowMin, $iColMin, $iRowSup, $iColSup) {
    for ($iRow = $iRowMin; $iRow < $iRowSup; ++$iRow) {
      if (!isset($this->cells[$iRow])) {
        throw new \RuntimeException('Illegal row index');
      }
      $rowCells =& $this->cells[$iRow];
      for ($iCol = $iColMin; $iCol < $iColSup; ++$iCol) {
        if (!isset($rowCells[$iCol])) {
          throw new \RuntimeException('Illegal col index');
        }
        if (!$rowCells[$iCol] instanceof PlaceholderCell) {
          throw new \RuntimeException('Illegal position');
        }
        $rowCells[$iCol] = $this->shadowCell;
      }
    }
  }

  /**
   * @param string[][][] $cellClasses
   */
  public function setCellClasses(array $cellClasses) {
    foreach ($cellClasses as $iRow => $rowCellClasses) {
      foreach ($rowCellClasses as $iCol => $classes) {
        $this->cells[$iRow][$iCol] = $this->cells[$iRow][$iCol]->addClasses($classes);
      }
    }
  }

  /**
   * @return \Donquixote\Cellbrush\Cell\CellInterface[][]
   */
  public function getCells() {
    return $this->cells;
  }

  /**
   * Renders the inner html of the table section.
   *
   * This is only used for testing.
   *
   * @return string
   *   The inner html of a table section.
   */
  public function renderAsTable() {
    $html = '';
    foreach ($this->cells as $iRow => $rowCells) {
      $rowHtml = '';
      foreach ($rowCells as $iCol => $cell) {
        $rowHtml .= $cell->render();
      }
      $html .= '    <tr>' . $rowHtml . '</tr>' . "\n";
    }
    return "<table>\n  <tbody>\n" . $html . "  </tbody>\n</table>\n";
  }

}
