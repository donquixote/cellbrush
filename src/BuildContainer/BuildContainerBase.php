<?php

namespace Donquixote\Cellbrush\BuildContainer;

use Donquixote\Cellbrush\Html\Multiple\StaticAttributesMap;
use Donquixote\Cellbrush\MiniContainer\MiniContainerBase;

/**
 * Settable properties:
 *
 * @property string[][] CellContents
 * @property string[][] CellTagNames
 * @property bool[][] OpenEndCells
 *   Array marking those cells that are open-end.
 *   Format: $[$rowName][$colName] = true.
 * @property StaticAttributesMap RowAttributes
 * @property string[][] RowStripings
 * @property StaticAttributesMap TableColAttributes
 * @property StaticAttributesMap SectionColAttributes
 */
class BuildContainerBase extends MiniContainerBase {

  public function __construct() {
    $this->defaults = array(
      'CellContents' => [],
      'CellTagNames' => [],
      'OpenEndCells' => [],
      'RowAttributes' => new StaticAttributesMap(),
      'RowStripings' => [],
      'TableColAttributes' => new StaticAttributesMap(),
      'SectionColAttributes' => new StaticAttributesMap(),
    );
  }

  /**
   * @param string[][] $cellContents
   *
   * @see BuildContainerBase::$CellContents
   */
  protected function validate_CellContents(array $cellContents) {
    // No validation, always accept.
  }

  /**
   * @param string[][] $cellTagNames
   *
   * @see BuildContainerBase::$CellTagNames
   */
  protected function validate_CellTagNames(array $cellTagNames) {
    // No validation, always accept.
  }

  /**
   * @param bool[][] $openEndCells
   *
   * @see BuildContainerBase::$OpenEndCells
   */
  protected function validate_OpenEndCells(array $openEndCells) {
    // No validation, always accept.
  }

  /**
   * @param \Donquixote\Cellbrush\Html\Multiple\StaticAttributesMap $rowAttributes
   *
   * @see BuildContainerBase::$RowAttributes
   */
  protected function validate_RowAttributes(StaticAttributesMap $rowAttributes) {
    // No validation, always accept.
  }

  /**
   * @param string[][] $rowStripings
   *   Format: $[] = ['odd', 'even']
   *
   * @see BuildContainerBase::$RowStripings
   */
  protected function validate_RowStripings(array $rowStripings) {
    // No validation, always accept.
  }

  /**
   * @param \Donquixote\Cellbrush\Html\Multiple\StaticAttributesMap $tableColAttributes
   */
  protected function validate_TableColAttributes(StaticAttributesMap $tableColAttributes) {
    // No validation, always accept.
  }

  /**
   * @param \Donquixote\Cellbrush\Html\Multiple\StaticAttributesMap $sectionColAttributes
   */
  protected function validate_SectionColAttributes(StaticAttributesMap $sectionColAttributes) {
    // No validation, always accept.
  }

}
