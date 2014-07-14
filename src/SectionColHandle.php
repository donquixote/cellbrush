<?php


namespace Donquixote\Cellbrush;


class SectionColHandle {

  /**
   * @var TableSection
   */
  private $tsection;

  /**
   * @var string
   */
  protected $colName;

  /**
   * @param TableSection $tsection
   * @param string $colName
   *
   * @internal param Table $table
   */
  function __construct(TableSection $tsection, $colName) {
    $this->tsection = $tsection;
    $this->colName = $colName;
  }

  /**
   * @param string $rowName
   * @param string $content
   *
   * @return $this
   */
  function td($rowName, $content) {
    $this->tsection->td($rowName, $this->colName, $content);
    return $this;
  }

  /**
   * @param string $rowName ,
   * @param string $content
   *
   * @return $this
   */
  function th($rowName, $content) {
    $this->tsection->th($rowName, $this->colName, $content);
    return $this;
  }

  /**
   * @param string[] $cells
   *   Format: $[$colName] = $content
   *
   * @return $this
   */
  function tdMultiple(array $cells) {
    foreach ($cells as $rowName => $content) {
      $this->tsection->td($rowName, $this->colName, $content);
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
    foreach ($cells as $rowName => $content) {
      $this->tsection->th($rowName, $this->colName, $content);
    }
    return $this;
  }

} 
