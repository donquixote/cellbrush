<?php

namespace Donquixote\Cellbrush;

class TableRows {

  /**
   * @var mixed[]
   */
  protected $rows = array();

  /**
   * @var string[]
   */
  private $rowNames = array();

  /**
   * @var int
   */
  private $iRow = 0;

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
      throw new \Exception("Row '$rowName' already exists.");
    }
    $this->rowNames[] = $rowName;
    $this->rows[$rowName] = $this->iRow++;
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
   * @return $this
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
        throw new \Exception("Rowumn '$rowName' already exists.");
      }
      $this->addRowName($rowName);
      $rowNames[] = $rowName;
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
   * @param string|string[] $rowRange
   *
   * @return string[]
   *
   * @throws \Exception
   */
  protected function rowRangeGetRowNames($rowRange) {
    if ('' === $rowRange) {
      return array_keys($this->rows);
    }
    if (is_array($rowRange)) {
      list($firstRowName, $lastRowName) = $rowRange;
      return $this->rowRangeDoGetRowNames($firstRowName, $lastRowName);
    }
    if (isset($this->rowGroups[$rowRange])) {
      return $this->rowGroups[$rowRange];
    }
    throw new \Exception("Unknown row group '$rowRange'.");
  }

  /**
   * @param string $firstRowName
   * @param string $lastRowName
   *
   * @throws \Exception
   * @return string[]
   */
  public function rowRangeDoGetRowNames($firstRowName, $lastRowName) {
    if (!isset($this->rows[$firstRowName])) {
      throw new \Exception("Unknown row name '$firstRowName'.");
    }
    if (!isset($this->rows[$lastRowName])) {
      throw new \Exception("Unknown row name '$lastRowName'.");
    }
    $iFirst = $this->rows[$firstRowName];
    $iLast = $this->rows[$lastRowName];
    if ($iFirst > $iLast) {
      throw new \Exception("Inverse range detected: $iFirst > $iLast.");
    }
    return array_slice($this->rowNames, $iFirst, $iLast - $iFirst + 1);
  }

} 
