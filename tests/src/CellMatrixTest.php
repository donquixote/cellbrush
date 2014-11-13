<?php

namespace Donquixote\Cellbrush\Tests;

use Donquixote\Cellbrush\Axis\SimpleRange;
use Donquixote\Cellbrush\Cell\Cell;
use Donquixote\Cellbrush\Cell\PlaceholderCell;
use Donquixote\Cellbrush\Cell\ShadowCell;
use Donquixote\Cellbrush\Matrix\CellMatrix;
use Donquixote\Cellbrush\Matrix\RangedBrush;

class CellMatrixTest extends \PHPUnit_Framework_TestCase {

  function testCellMatrix() {
    $cellMatrix = CellMatrix::create(1, 2);
    $rowRange = new SimpleRange(0, 1);
    $colRange = new SimpleRange(0, 1);
    $brush = new RangedBrush($rowRange, $colRange);
    $cell = new Cell('td', '0..1');

    $cellMatrix->addCell($brush, $cell);
    $this->assertEquals(
      [[
        $cell,
        new PlaceholderCell(),
      ]],
      $cellMatrix->getCells());

    $cellMatrix->brushCellGrowRight($brush);
    $this->assertEquals(
      [[
        $cell->setColspan(2),
        new ShadowCell(),
      ]],
      $cellMatrix->getCells());
  }
}
