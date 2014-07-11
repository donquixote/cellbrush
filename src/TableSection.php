<?php

namespace Donquixote\Cellbrush;

class TableSection {

  /**
   * @var TableColumns
   */
  private $columns;

  /**
   * @var true[]
   */
  private $rows = array();

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
   * @param string $rowName
   *
   * @return $this
   * @throws \Exception
   */
  function addRowName($rowName) {
    if (isset($this->rows[$rowName])) {
      throw new \Exception("Row '$rowName' already exists.");
    }
    $this->rows[$rowName] = TRUE;
    return $this;
  }

  /**
   * @param string[] $rowNames
   *
   * @return $this
   */
  public function addRowNames(array $rowNames) {
    foreach ($rowNames as $rowName) {
      $this->addRowName($rowName);
    }
    return $this;
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
   * @param string $rowName
   * @param string $colName
   * @param string $content
   *
   * @return $this
   * @throws \Exception
   */
  function td($rowName, $colName, $content) {
    if (!isset($this->rows[$rowName]) && '' !== $rowName) {
      throw new \Exception("Unknown row name '$rowName'.");
    }
    $this->columns->verifyColName($colName);
    $this->cells[$rowName][$colName] = array($content, 'td', array());
    return $this;
  }

  /**
   * @param string $rowName
   * @param string $colName
   * @param string $content
   *
   * @throws \Exception
   * @return $this
   */
  function th($rowName, $colName, $content) {
    if (!isset($this->rows[$rowName]) && '' !== $rowName) {
      throw new \Exception("Unknown row name '$rowName'.");
    }
    $this->columns->verifyColName($colName);
    $this->cells[$rowName][$colName] = array($content, 'th', array());
    return $this;
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
    $matrix = array();

    $cols = $this->columns->getCols();
    $colNames = array_keys($cols);

    // Fill all 1x1 cells.
    foreach ($this->rows as $rowName => $rTrue) {
      foreach ($cols as $colName => $cTrue) {
        $matrix[$rowName][$colName] = isset($this->cells[$rowName][$colName])
          ? $this->cells[$rowName][$colName]
          : array('', 'td', array());
      }
    }

    $colGroups = $this->columns->getColGroups();

    // Fill horizontal cell groups (colspan).
    foreach ($this->cells as $rowName => $rowCellGroups) {
      if (!isset($this->rows[$rowName])) {
        continue;
      }
      foreach ($rowCellGroups as $colGroupName => $cell) {
        if (!isset($colGroups[$colGroupName])) {
          continue;
        }
        $colNameSuffixes = $colGroups[$colGroupName];
        $cell[2]['colspan'] = count($colNameSuffixes);
        $matrix[$rowName][$colGroupName . '.' . $colNameSuffixes[0]] = $cell;
        for ($i = 1; $i < count($colNameSuffixes); ++$i) {
          unset($matrix[$rowName][$colGroupName . '.' . $colNameSuffixes[$i]]);
        }
      }
    }

    // Fill full-width cell groups (colspan).
    foreach ($this->cells as $rowName => $rowCellGroups) {
      if (!isset($this->rows[$rowName])) {
        continue;
      }
      if (!isset($rowCellGroups[''])) {
        continue;
      }
      $cell = $rowCellGroups[''];
      $cell[2]['colspan'] = count($cols);
      $matrix[$rowName][$colNames[0]] = $cell;
      for ($i = 1; $i < count($cols); ++$i) {
        unset($matrix[$rowName][$colNames[$i]]);
      }
    }

    // Fill full-height cell groups (rowspan).
    if (isset($this->cells[''])) {
      $rowNames = array_keys($this->rows);
      foreach ($this->cells[''] as $colName => $cell) {
        if (!isset($cols[$colName])) {
          continue;
        }
        $cell[2]['rowspan'] = count($rowNames);
        $matrix[$rowNames[0]][$colName] = $cell;
        for ($i = 1; $i < count($rowNames); ++$i) {
          unset($matrix[$rowNames[$i]][$colName]);
        }
      }
    }

    // Vertical cell groups are not implemented yet.
    return $matrix;
  }

} 
