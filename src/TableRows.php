<?php

namespace Donquixote\Cellbrush;

class TableRows {

  /**
   * @var mixed[]
   */
  protected $rows = array();

  /**
   * @var string[][]
   */
  protected $rowGroups = array();

  /**
   * @param string $rowName
   *
   * @return $this
   * @throws \Exception
   */
  public function addRowName($rowName) {
    if (isset($this->rows[$rowName])) {
      throw new \Exception("Column '$rowName' already exists.");
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
   * @param string $groupName
   * @param string[] $rowNameSuffixes
   *
   * @throws \Exception
   */
  public function addRowGroup($groupName, array $rowNameSuffixes) {
    if (empty($rowNameSuffixes)) {
      throw new \Exception("Suffixes cannot be empty.");
    }
    $rowNames = array();
    foreach ($rowNameSuffixes as $rowNameSuffix) {
      $rowName = $groupName . '.' . $rowNameSuffix;
      if (isset($this->rows[$rowName])) {
        throw new \Exception("Column '$rowName' already exists.");
      }
      $this->rows[$rowName] = $groupName;
      $rowNames[] = $rowName . '.' . $rowNameSuffix;
    }
    $this->rowGroups[$groupName] = $rowNames;
    return $this;
  }

  /**
   * @param string $rowName
   *
   * @throws \Exception
   */
  protected function verifyRowName($rowName) {
    if (1
      && !isset($this->rows[$rowName])
      && !isset($this->rowGroups[$rowName])
      && '' !== $rowName
    ) {
      throw new \Exception("Unknown row name '$rowName'.");
    }
  }

  /**
   * @param string $rowName
   *
   * @return bool
   */
  protected function rowExists($rowName) {
    return isset($this->rows[$rowName]);
  }

  /**
   * @param string $rowRange
   *
   * @return string[]
   *
   * @throws \Exception
   */
  protected function rowGroupGetRowNames($rowRange) {
    if ('' === $rowRange) {
      return array_keys($this->rows);
    }
    if (isset($this->rowGroups[$rowRange])) {
      return $this->rowGroups[$rowRange];
    }
    throw new \Exception("Unknown column group '$rowRange'.");
  }

} 
