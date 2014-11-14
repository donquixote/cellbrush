<?php

namespace Donquixote\Cellbrush\Tests;

use Donquixote\Cellbrush\Cell\Cell;
use Donquixote\Cellbrush\Matrix\CellMatrix;

class CellMatrixTest extends \PHPUnit_Framework_TestCase {

  function testRowspanSimple() {
    $cellMatrix = CellMatrix::create(2, 1);
    $cell = (new Cell('td', 'cell with rowspan'))->setRowspan(2);
    $cellMatrix->addCell(0, 0, $cell);

    $expected = <<<EOT
<table>
  <tbody>
    <tr><td rowspan="2">cell with rowspan</td></tr>
    <tr></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $cellMatrix->renderAsTable());
  }

  function testOpenEnd() {
    $cellMatrix = CellMatrix::create(1, 2);
    $cell = (new Cell('td', 'cell with colspan'));
    $cellMatrix->addCell(0, 0, $cell);

    $expected = <<<EOT
<table>
  <tbody>
    <tr><td>cell with colspan</td><td></td></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $cellMatrix->renderAsTable());

    $success = $cellMatrix->cellGrowRight(0, 0, 2);
    $this->assertTrue($success);

    $expected = <<<EOT
<table>
  <tbody>
    <tr><td colspan="2">cell with colspan</td></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $cellMatrix->renderAsTable());
  }

  function testRowspanAndOpenEnd() {
    $cellMatrix = CellMatrix::create(3, 4);
    $cell = (new Cell('td', 'cell with rowspan'))->setRowspan(2);
    $cellMatrix->addCell(0, 1, $cell);

    $expected = <<<EOT
<table>
  <tbody>
    <tr><td></td><td rowspan="2">cell with rowspan</td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td><td></td></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $cellMatrix->renderAsTable());

    $cellMatrix->cellGrowRight(0, 1, 3);

    $expected = <<<EOT
<table>
  <tbody>
    <tr><td></td><td rowspan="2" colspan="2">cell with rowspan</td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td><td></td><td></td></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $cellMatrix->renderAsTable());
  }

}
