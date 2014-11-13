<?php


namespace Donquixote\Cellbrush\Axis;

class Axis implements RangeInterface {

  /**
   * @var string[]
   *   Format: $[] = $name
   */
  private $toplevelNames;

  /**
   * @var string[]
   *   Format: $[$name] = $toplevelLocalIndex
   */
  private $toplevelMap;

  /**
   * @var true[][]
   *   Format: $[$parentName][$childName] = true
   */
  private $children;

  /**
   * @var string[][]
   *   Format: $[$parentName][$childLocalIndex] = $childName
   */
  private $childNames;

  /**
   * @var int[][]
   *   Format: $[$parentName][$childName] = $childLocalIndex
   */
  private $childMap;

  /**
   * @var mixed[]
   *   Format: $[$childName] = $parentName|null
   */
  private $parents;

  /**
   * @var int[]
   *   Format: $[$name] = $index
   */
  private $leafMap = array();

  /**
   * @var int[][]
   *   Format: $[$parentName][$leafName] = $leafIndex
   */
  private $subtreeLeafMap = array();

  /**
   * @var int
   */
  private $leafCount;

  /**
   * @param true[][] $toplevelNames
   * @param true[][] $children
   * @param mixed[] $parents
   *   Format: $[$childName] = $parentName|null
   */
  function __construct(array $toplevelNames, array $children, array $parents) {
    $this->toplevelNames = array_keys($toplevelNames);
    $this->toplevelMap = array_flip($this->toplevelNames);
    $this->children = $children;
    $this->childNames = array_map('array_keys', $children);
    $this->childMap = array_map('array_flip', $this->childNames);
    $this->parents = $parents;
    $this->initLeafNames();
    $this->leafCount = count($this->leafMap);
  }

  /**
   * Initializes $this->leafNames and $this->subtreeLeafNames.
   */
  private function initLeafNames() {
    $index = 0;
    foreach ($this->toplevelNames as $name) {
      if (empty($this->children[$name])) {
        // This is a leaf.
        $this->subtreeLeafMap[$name][$name] = $index;
        $this->leafMap[$name] = $index;
        ++$index;
      }
      else {
        // This is a node with a subtree.
        $this->initSubtreeLeafNames($name, $index);
        $this->leafMap += $this->subtreeLeafMap[$name];
      }
    }
  }

  /**
   * Initializes $this->subtreeLeafNames for deeper levels, recursively.
   *
   * @param string $parentName
   * @param $index
   */
  private function initSubtreeLeafNames($parentName, &$index) {
    $this->subtreeLeafMap[$parentName] = array();
    foreach ($this->children[$parentName] as $name => $cTrue) {
      if (empty($this->children[$name])) {
        // This is a leaf.
        $this->subtreeLeafMap[$name][$name] = $index;
        $this->subtreeLeafMap[$parentName][$name] = $index;
        ++$index;
      }
      else {
        // This is a node with a subtree.
        $this->initSubtreeLeafNames($name, $index);
        $this->subtreeLeafMap[$parentName] += $this->subtreeLeafMap[$name];
      }
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
   * @return string[]
   */
  public function getLeafNames() {
    return array_keys($this->leafMap);
  }

  /**
   * @return int[]
   */
  public function getLeafMap() {
    return $this->leafMap;
  }

  /**
   * @param string $name
   *
   * @return int
   */
  public function nameIsLeaf($name) {
    return ('' === $name)
      ? empty($this->leafMap)
      : isset($this->leafMap[$name]);
  }

  /**
   * @param string $parentName
   *
   * @return string[]
   */
  public function subtreeLeafNames($parentName) {
    return ('' === $parentName)
      ? array_keys($this->leafMap)
      : array_keys($this->subtreeLeafMap[$parentName]);
  }

  /**
   * @param string $parentName
   *
   * @return int[]
   */
  public function subtreeLeafMap($parentName) {
    return ('' === $parentName)
      ? $this->leafMap
      : $this->subtreeLeafMap[$parentName];
  }

  /**
   * @param string $parentName
   *
   * @return int
   */
  public function subtreeLeafCount($parentName) {
    return ('' === $parentName)
      ? count($this->leafMap)
      : count($this->subtreeLeafMap[$parentName]);
  }

  /**
   * @param string $parentName
   *
   * @return int
   */
  public function subtreeIndex($parentName) {
    return ('' === $parentName)
      ? 0
      : reset($this->subtreeLeafMap[$parentName]);
  }

  /**
   * @param $parentName
   *
   * @return RangeInterface
   * @throws \Exception
   */
  public function subtreeRange($parentName) {
    if ('' === $parentName) {
      // Return the full axis as a range.
      return $this;
    }
    if (!isset($this->subtreeLeafMap[$parentName])) {
      throw new \Exception("Unknown name: " . var_export($parentName, true));
    }
    $iBegin = reset($this->subtreeLeafMap[$parentName]);
    $iEnd = $iBegin + count($this->subtreeLeafMap[$parentName]);
    return new Range($iBegin, $iEnd, $parentName, $this);
  }

  /**
   * @param string $name
   *
   * @return string|null
   */
  public function nameGetNextName($name) {
    $parentName = $this->parents[$name];
    if (!isset($parentName)) {
      $siblingNames = $this->toplevelNames;
      $siblingMap = $this->toplevelMap;
    }
    else {
      $siblingNames = $this->childNames[$parentName];
      $siblingMap = $this->childMap[$parentName];
    }
    $index = $siblingMap[$name];
    return isset($siblingNames[$index + 1])
      ? $siblingNames[$index + 1]
      : null;
  }

  /**
   * @return int
   */
  public function getCount() {
    return $this->leafCount;
  }

  /**
   * @return int
   */
  function iMin() {
    return 0;
  }

  /**
   * @return int
   */
  function iSup() {
    return $this->leafCount;
  }

  /**
   * @return int
   */
  public function iMax() {
    return $this->leafCount - 1;
  }

  /**
   * @return int[]
   *   Format: [$iMin, $iSup]
   */
  function getMinSup() {
    return [0, $this->leafCount];
  }

  /**
   * @return static|null
   */
  public function getNext() {
    return null;
  }

  /**
   * @param int $iSup
   *
   * @return static
   */
  public function setSup($iSup) {
    throw new \RuntimeException('nope');
  }

  /**
   * @return int[]
   */
  public function getIndices() {
    return array_values($this->leafMap);
  }

  /**
   * @param int $span
   *
   * @return static
   */
  public function setSpan($span) {
    throw new \RuntimeException('nope');
  }
}
