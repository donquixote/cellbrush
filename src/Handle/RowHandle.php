<?php

namespace Donquixote\Cellbrush\Handle;

use Donquixote\Cellbrush\TSection\TableSection;

class RowHandle {

  /**
   * @var TableSection
   */
  private $tsection;

  /**
   * @var string
   */
  private $rowName;

  /**
   * @param TableSection $tsection
   * @param string $rowName
   */
  function __construct(TableSection $tsection, $rowName) {
    $this->tsection = $tsection;
    $this->rowName = $rowName;
  }

  /**
   * @param string $colName
   * @param string $content
   *
   * @return $this
   */
  function td($colName, $content) {
    $this->tsection->td($this->rowName, $colName, $content);
    return $this;
  }

  /**
   * @param string $colName
   * @param string $content
   *
   * @return $this
   */
  function th($colName, $content) {
    $this->tsection->th($this->rowName, $colName, $content);
    return $this;
  }

  /**
   * @param string[] $cells
   *   Format: $[$colName] = $content
   *
   * @return $this
   */
  function tdMultiple(array $cells) {
    foreach ($cells as $colName => $content) {
      $this->tsection->td($this->rowName, $colName, $content);
    }
    return $this;
  }

  /**
   * @param string[] $cells
   *   Format: $[$colName] = $content
   *
   * @return $this
   */
  function thMultiple(array $cells) {
    foreach ($cells as $colName => $content) {
      $this->tsection->th($this->rowName, $colName, $content);
    }
    return $this;
  }

  /**
   * Adds a td cell with a colspan that ends where the next known cell begins.
   *
   * @param string|string[] $colName
   *   Column name, group or range.
   * @param string $content
   *   HTML cell content.
   *
   * @return $this
   */
  function tdOpenEnd($colName, $content) {
    $this->tsection->tdOpenEnd($this->rowName, $colName, $content);
    return $this;
  }

  /**
   * Adds a th cell with a colspan that ends where the next known cell begins.
   *
   * @param string|string[] $colName
   *   Column name, group or range.
   * @param string $content
   *   HTML cell content.
   *
   * @return $this
   */
  public function thOpenEnd($colName, $content) {
    $this->tsection->thOpenEnd($this->rowName, $colName, $content);
  }

}
