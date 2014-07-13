<?php

namespace Donquixote\Cellbrush;

class TableSection extends TableRows {

  /**
   * @var TableColumns
   */
  private $columns;

  /**
   * @var string[][]
   */
  private $rowAttributes;

  /**
   * @var array[][]
   */
  private $cells = array();

  /**
   * @param TableColumns $columns
   */
  function __construct(TableColumns $columns) {
    $this->columns = $columns;
  }

  /**
   * @param string $colName
   *
   * @return SectionColHandle
   * @throws \Exception
   */
  public function colHandle($colName) {
    $this->columns->verifyColName($colName);
    return new SectionColHandle($this, $colName);
  }

  /**
   * @param string $rowName
   *
   * @return RowHandle
   * @throws \Exception
   */
  public function rowHandle($rowName) {
    if (isset($this->rows[$rowName])) {
      throw new \Exception("Row '$rowName' does not exist.");
    }
    return new RowHandle($this, $rowName);
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
    if (isset($this->rows[$rowName])) {
      throw new \Exception("Row '$rowName' already exists.");
    }
    $this->rows[$rowName] = TRUE;
    return new RowHandle($this, $rowName);
  }

  /**
   * @param string $rowName
   * @param string $class
   *
   * @return $this
   */
  public function addRowClass($rowName, $class) {
    $this->rowAttributes[$rowName]['class'][] = $class;
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
    $this->addCell($rowName, $colName, 'td', $content);
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
    $this->addCell($rowName, $colName, 'th', $content);
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
  private function addCell($rowName, $colName, $tagName, $content) {
    $cellAttributes = array();
    if (!is_array($rowName) && isset($this->rows[$rowName])) {
      // Cell spans only one row.
      if (!is_array($colName) && $this->columns->columnExists($colName)) {
        // Cell spans only one column (1 * 1).
      }
      else {
        // Cell spans multiple columns (1 * m).
        $colNames = $this->columns->colGroupGetColNames($colName);
        $cellAttributes['colspan'] = $colspan = count($colNames);
        $colName = array_shift($colNames);
        // Mark to-be-skipped positions in row.
        foreach ($colNames as $colNameToSkip) {
          $this->markCell($rowName, $colNameToSkip);
        }
      }
    }
    else {
      // Cell spans multiple rows.
      $rowNames = $this->rowRangeGetRowNames($rowName);
      $cellAttributes['rowspan'] = $rowspan = count($rowNames);
      $rowName = array_shift($rowNames);
      if (!is_array($colName) && $this->columns->columnExists($colName)) {
        // Cell spans only one column (n * 1).
      }
      else {
        // Cell spans multiple columns (n * m).
        $colNames = $this->columns->colGroupGetColNames($colName);
        $cellAttributes['colspan'] = $colspan = count($colNames);
        $colName = array_shift($colNames);
        // Mark to-be-skipped positions in the row and the area below.
        foreach ($colNames as $colNameToSkip) {
          $this->markCell($rowName, $colNameToSkip);
          foreach ($rowNames as $rowNameToSkip) {
            $this->markCell($rowNameToSkip, $colNameToSkip);
          }
        }
      }
      // Mark to-be-skipped positions in column.
      foreach ($rowNames as $rowNameToSkip) {
        $this->markCell($rowNameToSkip, $colName);
      }
    }

    if (isset($this->cells[$rowName][$colName])) {
      throw new \Exception("Cannot overwrite cell at '$rowName'/'$colName'.");
    }
    $this->cells[$rowName][$colName] = array($content, $tagName, $cellAttributes);
  }

  /**
   * @param string $rowName
   * @param string $colName
   *
   * @throws \Exception
   */
  private function markCell($rowName, $colName) {
    if (isset($this->cells[$rowName][$colName])) {
      throw new \Exception("Cannot overwrite cell at '$rowName'/'$colName'.");
    }
    $this->cells[$rowName][$colName] = TRUE;
  }

  /**
   * @param string $sectionTagName
   *   Either 'thead' or 'tbody' or 'tfoot'.
   *
   * @return string
   *   Rendered table html.
   */
  function render($sectionTagName) {
    $html = '';
    foreach ($this->getMatrix() as $rowName => $rowCells) {
      $rowHtml = '';
      foreach ($rowCells as $colName => $cell) {
        list($cellHtml, $tagName, $attributes) = $cell;
        $attributes = !empty($attributes)
          ? Util::htmlAttributes($attributes)
          : '';
        $rowHtml .= '<' . $tagName . $attributes . '>' . $cellHtml . '</' . $tagName . '>';
      }
      $rowAttributes = isset($this->rowAttributes[$rowName])
        ? Util::htmlAttributes($this->rowAttributes[$rowName])
        : '';
      $html .= '    <tr' . $rowAttributes . '>' . $rowHtml . '</tr>' . "\n";
    }
    if ('' === $html) {
      return '';
    }
    return '  <' . $sectionTagName . '>' . "\n" . $html . '  </' . $sectionTagName . '>' . "\n";
  }

  /**
   * @return array[][]
   */
  private function getMatrix() {

    // Create an empty n*m matrix.
    $matrix = array();
    $emptyRow = array_fill_keys($this->columns->getColNames(), array('', 'td', array()));
    foreach ($this->rows as $rowName => $rTrue) {
      $matrix[$rowName] = $emptyRow;
    }

    // Fill in the known cells.
    foreach ($this->cells as $rowName => $rowCells) {
      foreach ($rowCells as $colName => $cell) {
        if (TRUE === $cell) {
          // This cell needs to be left out due to colspan / rowspan.
          unset($matrix[$rowName][$colName]);
        }
        else {
          $matrix[$rowName][$colName] = $cell;
        }
      }
    }

    return $matrix;
  }

} 
