<?php

namespace Donquixote\Cellbrush\Internals;


use Donquixote\Cellbrush\TableColumns;
use Donquixote\Cellbrush\TableRows;

class MaterializedCellMatrix {

  /**
   * @var array[][]
   *   Format: $[$rowName][$colName] = [$cellContent, ..]
   */
  private $cells = array();

  /**
   * @param TableRows $rows
   * @param TableColumns $columns
   */
  function __construct(TableRows $rows, TableColumns $columns) {
    // Create an empty n*m matrix.
    $emptyRow = array_fill_keys($columns->getColNames(), array('', 'td', array()));
    foreach ($rows->getRowNames() as $rowName) {
      $this->cells[$rowName] = $emptyRow;
    }
  }

  /**
   * @param array[][] $cells
   *   Format: $[$rowName][$colName] = []
   */
  function addCells($cells) {
    // Fill in the known cells, and remove cells that are left out for rowspan
    // or colspan of other cells.
    foreach ($cells as $rowName => $rowCells) {
      foreach ($rowCells as $colName => $cell) {
        if (TRUE === $cell) {
          // This cell needs to be left out due to colspan / rowspan.
          unset($this->cells[$rowName][$colName]);
        }
        else {
          $this->cells[$rowName][$colName] = $cell;
        }
      }
    }
  }

  function add

} 
