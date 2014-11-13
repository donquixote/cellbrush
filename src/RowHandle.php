<?php


namespace Donquixote\Cellbrush;


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
   *
   * @internal param Table $table
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

}
