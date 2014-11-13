<?php


namespace Donquixote\Cellbrush\Tests;

use Donquixote\Cellbrush\Axis\DynamicAxis;

class HierarchyTest extends \PHPUnit_Framework_TestCase {

  function testFlat() {
    $hierarchy = new DynamicAxis();
    $hierarchy->addNames(['A', 'B']);
    $hierarchy->addName('C');
    $snapshot = $hierarchy->takeSnapshot();
    $this->assertEquals(['A', 'B', 'C'], $snapshot->getLeafNames());
    $this->assertEquals(['A'], $snapshot->subtreeLeafNames('A'));
    $this->assertEquals(['C'], $snapshot->subtreeLeafNames('C'));
  }

  function testNested() {
    $hierarchy = new DynamicAxis();
    $hierarchy->addNames(['A.x', 'A.y', 'B.x']);
    $hierarchy->addName('A.x.22');

    $this->assertEquals(
      [
        'A.x' => [
          'A.x.22' => true,
        ],
        'A' => [
          'A.x' => true,
          'A.y' => true,
        ],
        'A.y' => [],
        'B.x' => [],
        'B' => [
          'B.x' => true,
        ],
        'A.x.22' => [],
      ],
      $hierarchy->getChildren());

    $this->assertEquals(
      [
        'A.x' => 'A',
        'A.y' => 'A',
        'B.x' => 'B',
        'A' => null,
        'B' => null,
        'A.x.22' => 'A.x',
      ],
      $hierarchy->getParents());

    $this->assertEquals(
      ['A' => true, 'B' => true],
      $hierarchy->getToplevelNames());

    $snapshot = $hierarchy->takeSnapshot();

    $this->assertEquals(
      ['A.x.22', 'A.y', 'B.x'],
      $snapshot->getLeafNames());
  }
}
