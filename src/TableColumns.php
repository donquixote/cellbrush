<?php

namespace Donquixote\Cellbrush;

class TableColumns {

  /**
   * @var int[]
   */
  private $cols = array();

  /**
   * @var string[]
   */
  private $colNames = array();

  /**
   * @var int
   */
  private $iCol = 0;

  /**
   * @var string[][]
   */
  private $colGroups = array();

  /**
   * Column classes for all table sections.
   *
   * @var string[][]
   *   Format: $[$rowName][] = $class
   */
  private $colClasses = array();

  /**
   * @return mixed[]
   */
  public function getCols() {
    return $this->cols;
  }

  /**
   * @return string[]
   */
  public function getColNames() {
    return $this->colNames;
  }

  /**
   * @return string[][]
   */
  public function getColGroups() {
    return $this->colGroups;
  }

  /**
   * @param string $colName
   *
   * @throws \Exception
   */
  function addColName($colName) {
    if (isset($this->cols[$colName])) {
      throw new \Exception("Column '$colName' already exists.");
    }
    $this->colNames[] = $colName;
    $this->cols[$colName] = $this->iCol++;
  }

  /**
   * @param string[] $colNames
   *
   * @return $this
   */
  function addColNames(array $colNames) {
    foreach ($colNames as $colName) {
      $this->addColName($colName);
    }
  }

  /**
   * @param string $groupName
   * @param string[] $colNameSuffixes
   *
   * @throws \Exception
   */
  function addColGroup($groupName, array $colNameSuffixes) {
    if (empty($colNameSuffixes)) {
      throw new \Exception("Suffixes cannot be empty.");
    }
    $colNames = array();
    foreach ($colNameSuffixes as $colNameSuffix) {
      $colName = $groupName . '.' . $colNameSuffix;
      $this->addColName($colName);
      $colNames[] = $colName;
    }
    $this->colGroups[$groupName] = $colNames;
  }

  /**
   * @param string $colName
   * @param string $class
   */
  public function addColClass($colName, $class) {
    $this->colClasses[$colName][] = $class;
  }

  /**
   * @param string[] $colClasses
   *   Format: $[$colName] = $class
   */
  function addColClasses(array $colClasses) {
    foreach ($colClasses as $colName => $class) {
      $this->colClasses[$colName][] = $class;
    }
  }

  /**
   * @return string[][]
   *   Format: $[$rowName][] = $class
   */
  public function getColClasses() {
    return $this->colClasses;
  }

  /**
   * @param string $colName
   *
   * @throws \Exception
   */
  public function verifyColName($colName) {
    if (1
      && !isset($this->cols[$colName])
      && !isset($this->colGroups[$colName])
      && '' !== $colName
    ) {
      throw new \Exception("Unknown column name '$colName'.");
    }
  }

  /**
   * @param string $colName
   *
   * @return bool
   */
  public function columnExists($colName) {
    return isset($this->cols[$colName]);
  }

  /**
   * @param string|string[] $colRange
   *
   * @return string[]
   *
   * @throws \Exception
   */
  public function colGroupGetColNames($colRange) {
    if ('' === $colRange) {
      return array_keys($this->cols);
    }
    if (is_array($colRange)) {
      list($firstColName, $lastColName) = $colRange;
      return $this->colRangeDoGetColNames($firstColName, $lastColName);
    }
    if (isset($this->colGroups[$colRange])) {
      return $this->colGroups[$colRange];
    }
    throw new \Exception("Unknown column group '$colRange'.");
  }

  /**
   * @param string $firstColName
   * @param string $lastColName
   *
   * @throws \Exception
   * @return string[]
   */
  public function colRangeDoGetColNames($firstColName, $lastColName) {
    if (!isset($this->cols[$firstColName])) {
      throw new \Exception("Unknown col name '$firstColName'.");
    }
    if (!isset($this->cols[$lastColName])) {
      throw new \Exception("Unknown col name '$lastColName'.");
    }
    $iFirst = $this->cols[$firstColName];
    $iLast = $this->cols[$lastColName];
    if ($iFirst > $iLast) {
      throw new \Exception("Inverse range detected: $iFirst > $iLast.");
    }
    return array_slice($this->colNames, $iFirst, $iLast - $iFirst + 1);
  }

}
