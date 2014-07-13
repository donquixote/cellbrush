<?php

namespace Donquixote\Cellbrush;

class TableColumns {

  /**
   * @var mixed[]
   */
  private $cols = array();

  /**
   * @var string[][]
   */
  private $colGroups = array();

  /**
   * @return mixed[]
   */
  public function getCols() {
    return $this->cols;
  }

  public function getColNames() {
    return array_keys($this->cols);
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
    $this->cols[$colName] = TRUE;
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
      if (isset($this->cols[$colName])) {
        throw new \Exception("Column '$colName' already exists.");
      }
      $this->cols[$colName] = $groupName;
      $colNames[] = $colName;
    }
    $this->colGroups[$groupName] = $colNames;
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
   * @param string $colName
   *
   * @return string[]
   *
   * @throws \Exception
   */
  public function colGroupGetColNames($colName) {
    if ('' === $colName) {
      return array_keys($this->cols);
    }
    if (isset($this->colGroups[$colName])) {
      return $this->colGroups[$colName];
    }
    throw new \Exception("Unknown column group '$colName'.");
  }

} 
