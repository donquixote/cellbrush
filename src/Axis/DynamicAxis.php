<?php

namespace Donquixote\Cellbrush\Axis;

/**
 * This is used for row names and column names.
 */
class DynamicAxis {

  /**
   * @var true[]
   */
  private $toplevelNames = array();

  /**
   * @var true[][]
   *   Format: $[$parentName][$childName] = true
   */
  private $children = array();

  /**
   * @var mixed[]
   *   Format: $[$childName] = $parentName|null
   */
  private $parents = array();

  /**
   * @param string $name
   *
   * @return $this
   * @throws \Exception
   */
  function addName($name) {
    if (isset($this->children[$name])) {
      throw new \Exception("Name '$name' already exists.");
    }
    $this->internalAddName($name);
    return $this;
  }

  /**
   * @param string $name
   *
   * @return $this
   */
  public function addNameIfNotExists($name) {
    if (!isset($this->children[$name])) {
      $this->internalAddName($name);
    }
    return $this;
  }

  /**
   * Adds a name from which we know already it does not exist.
   * This allows to avoid redundant checks when called internally.
   *
   * @param string $name
   */
  private function internalAddName($name) {
    $this->children[$name] = array();
    if (false !== $pos = strrpos($name, '.')) {
      $parentName = substr($name, 0, $pos);
      if (!isset($this->children[$parentName])) {
        $this->internalAddName($parentName);
      }
      $this->parents[$name] = $parentName;
      $this->children[$parentName][$name] = true;
    }
    else {
      $this->parents[$name] = null;
      $this->toplevelNames[$name] = true;
    }
  }

  /**
   * @param string[] $names
   *
   * @return $this
   */
  function addNames(array $names) {
    foreach ($names as $name) {
      $this->addName($name);
    }
  }

  /**
   * @param string $name
   *
   * @throws \Exception
   */
  public function verifyName($name) {
    if (1
      && isset($name)
      && !isset($this->children[$name])
    ) {
      throw new \Exception("Unknown name '$name'.");
    }
  }

  /**
   * @param string $name
   *
   * @return bool
   */
  public function nameExists($name) {
    return isset($this->children[$name]);
  }

  /**
   * Sets the order for all children of a parent, or all toplevel names.
   * This operation cannot add or remove names, only reorder them. If names
   * would be added or removed, an exception is thrown instead.
   *
   * @param string[] $orderedNames
   * @param string|null $parentName
   *
   * @return $this
   * @throws \Exception
   */
  function setOrder(array $orderedNames, $parentName = NULL) {
    if (isset($parentName)) {
      if (!isset($this->children[$parentName])) {
        throw new \Exception("Unknown name '$parentName'.");
      }
      $this->children[$parentName] = $this->internalSetOrder(
        $this->children[$parentName],
        $orderedNames);
    }
    else {
      $this->toplevelNames = $this->internalSetOrder(
        $this->toplevelNames,
        $orderedNames);
    }
    return $this;
  }

  /**
   * @param true[] $originalOrder
   * @param string[] $orderedNames
   *
   * @return true[]
   * @throws \Exception
   */
  private function internalSetOrder(array $originalOrder, array $orderedNames) {
    $newOrder = array();
    foreach ($orderedNames as $name) {
      if (!isset($originalOrder[$name])) {
        // No names can be added here.
        throw new \Exception("Name '$name' does not exist.");
      }
      $newOrder[$name] = true;
      unset($originalOrder[$name]);
    }
    foreach ($originalOrder as $name => $cTrue) {
      // No names can be removed here.
      throw new \Exception("Cannot remove name '$name' in setOrder().");
    }
    return $newOrder;
  }

  /**
   * @param string $groupName
   * @param string[] $nameSuffixes
   *
   * @return $this
   * @throws \Exception
   */
  public function addGroup($groupName, $nameSuffixes) {
    // @todo More performant dedicated implementation.
    foreach ($nameSuffixes as $suffix) {
      $this->addName($groupName . '.' . $suffix);
    }
  }

  /**
   * @return Axis
   */
  public function takeSnapshot() {
    return new Axis($this->toplevelNames, $this->children, $this->parents);
  }

  /**
   * @return mixed[]
   */
  public function getParents() {
    return $this->parents;
  }

  /**
   * @return mixed[]
   */
  public function getChildren() {
    return $this->children;
  }

  /**
   * @return true[]
   */
  public function getToplevelNames() {
    return $this->toplevelNames;
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return empty($this->toplevelNames);
  }
}
