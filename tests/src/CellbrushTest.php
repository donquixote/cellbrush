<?php

namespace Donquixote\Cellbrush\Tests;

use Donquixote\Cellbrush\Table;

class CellbrushTest extends \PHPUnit_Framework_TestCase {

  function testRegularTable() {
    $table = (new Table())
      ->addRowName('row0')
      ->addRowName('row1')
      ->addRowName('row2')
      ->addColName('col0')
      ->addColName('col1')
      ->addColName('col2')
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
    ;
    $table->thead()
      ->addRowName('head0')
      ->th('head0', 'col0', 'Column 0')
      ->th('head0', 'col1', 'Column 1')
      ->th('head0', 'col2', 'Column 2')
    ;
    $html = $table->render();

    $expected = <<<EOT
<table>
  <thead>
    <tr><th>Column 0</th><th>Column 1</th><th>Column 2</th></tr>
  </thead>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td></tr>
    <tr><td></td><td>Diag 1</td><td></td></tr>
    <tr><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $html);
  }

  function testFullRowspan() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('', 'col1', 'Full rowspan')
      ->td('row2', 'col2', 'Diag 2')
    ;
    $expected = <<<EOT
<table>
  <tbody>
    <tr><td>Diag 0</td><td rowspan="3">Full rowspan</td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;
    $this->assertEquals($expected, $table->render());
  }

  function testFullColspan() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', '', 'Full colspan')
      ->td('row2', 'col2', 'Diag 2')
    ;
    $expected = <<<EOT
<table>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td></tr>
    <tr><td colspan="3">Full colspan</td></tr>
    <tr><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;
    $this->assertEquals($expected, $table->render());
  }

  function testColGroups() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
      ->addColGroup('cg', ['a', 'b', 'c'])
      ->td('row0', 'cg.a', 'GD 0.a')
      ->td('row0', 'cg.b', 'GD 0.b')
      ->td('row1', 'cg', 'Span')
      ->td('row2', 'cg.a', 'GD 3.a')
      ->td('row2', 'cg.c', 'GD 3.c')
    ;
    $expected = <<<EOT
<table>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td><td>GD 0.a</td><td>GD 0.b</td><td></td></tr>
    <tr><td></td><td>Diag 1</td><td></td><td colspan="3">Span</td></tr>
    <tr><td></td><td></td><td>Diag 2</td><td>GD 3.a</td><td></td><td>GD 3.c</td></tr>
  </tbody>
</table>

EOT;
    $this->assertEquals($expected, $table->render());
  }

  function testRowHandle() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
    ;
    $table->thead()->addRow('head0')
      ->th('col0', 'Column 0')
      ->th('col1', 'Column 1')
      ->th('col2', 'Column 2')
    ;
    $expected = <<<EOT
<table>
  <thead>
    <tr><th>Column 0</th><th>Column 1</th><th>Column 2</th></tr>
  </thead>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td></tr>
    <tr><td></td><td>Diag 1</td><td></td></tr>
    <tr><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;
    $this->assertEquals($expected, $table->render());
  }

  function testColHandle() {
    $table = new Table();
    $table
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['legend', 'col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
    ;
    $table->colHandle('legend')
      ->th('row0', 'Row 0')
      ->th('row1', 'Row 1')
      ->th('row2', 'Row 2')
    ;
    $expected = <<<EOT
<table>
  <tbody>
    <tr><th>Row 0</th><td>Diag 0</td><td></td><td></td></tr>
    <tr><th>Row 1</th><td></td><td>Diag 1</td><td></td></tr>
    <tr><th>Row 2</th><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;
    $this->assertEquals($expected, $table->render());
  }

  function testRowAndColHandle() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['legend', 'col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
    ;
    $table->thead()->addRow('head0')
      ->thMultiple(
        [
          'col0' => 'Column 0',
          'col1' => 'Column 1',
          'col2' => 'Column 2',
        ]
      )
    ;
    $table->colHandle('legend')
      ->thMultiple(
        [
          'row0' => 'Row 0',
          'row1' => 'Row 1',
          'row2' => 'Row 2',
        ]
      )
    ;
    $expected = <<<EOT
<table>
  <thead>
    <tr><td></td><th>Column 0</th><th>Column 1</th><th>Column 2</th></tr>
  </thead>
  <tbody>
    <tr><th>Row 0</th><td>Diag 0</td><td></td><td></td></tr>
    <tr><th>Row 1</th><td></td><td>Diag 1</td><td></td></tr>
    <tr><th>Row 2</th><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;
    $this->assertEquals($expected, $table->render());
  }

  function testCellRange() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Cell 0.0')
      ->td('row1', 'col0', 'Cell 1.0')
      ->td('row2', 'col0', 'Cell 2.0')
      ->td('row2', 'col1', 'Cell 2.1')
      ->td('row2', 'col2', 'Cell 2.2')
      ->td(['row0', 'row1'], ['col1', 'col2'], 'Range box')
    ;

    $expected = <<<EOT
<table>
  <tbody>
    <tr><td>Cell 0.0</td><td rowspan="2" colspan="2">Range box</td></tr>
    <tr><td>Cell 1.0</td></tr>
    <tr><td>Cell 2.0</td><td>Cell 2.1</td><td>Cell 2.2</td></tr>
  </tbody>
</table>

EOT;
    $this->assertEquals($expected, $table->render());
  }

  function testCellRangeOverlap() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->th('row1', 'col1', 'Middle')
      ->td('row0', ['col0', 'col1'], '0.0 - 0.1')
      ->td('row2', ['col1', 'col2'], '2.1 - 2.2')
      ->td(['row1', 'row2'], 'col0', '1.0<br/>2.0')
      ->td(['row0', 'row1'], 'col2', '0.2<br/>1.2')
    ;

    $expected = <<<EOT
<table>
  <tbody>
    <tr><td colspan="2">0.0 - 0.1</td><td rowspan="2">0.2<br/>1.2</td></tr>
    <tr><td rowspan="2">1.0<br/>2.0</td><th>Middle</th></tr>
    <tr><td colspan="2">2.1 - 2.2</td></tr>
  </tbody>
</table>

EOT;
    $this->assertEquals($expected, $table->render());
  }

  function testRowClass() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
      ->addRowClasses(
        [
          'row0' => 'rowClass0',
          'row1' => 'rowClass1',
          'row2' => 'rowClass2',
        ])
      ->addRowClass('row2', 'extraClass')
    ;
    $table->tbody()
      ->addRowClass('row1', 'otherClass')
    ;

    $expected = <<<EOT
<table>
  <tbody>
    <tr class="rowClass0"><td>Diag 0</td><td></td><td></td></tr>
    <tr class="rowClass1 otherClass"><td></td><td>Diag 1</td><td></td></tr>
    <tr class="rowClass2 extraClass"><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $table->render());
  }

  function testRowStripingOddEven() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2', 'row3', 'row4', 'row5'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
      ->td('row3', 'col0', 'Diag 0')
      ->td('row4', 'col1', 'Diag 1')
      ->td('row5', 'col2', 'Diag 2')
      // Basic odd/even striping
      ->addRowStriping()
    ;

    $expected = <<<EOT
<table>
  <tbody>
    <tr class="odd"><td>Diag 0</td><td></td><td></td></tr>
    <tr class="even"><td></td><td>Diag 1</td><td></td></tr>
    <tr class="odd"><td></td><td></td><td>Diag 2</td></tr>
    <tr class="even"><td>Diag 0</td><td></td><td></td></tr>
    <tr class="odd"><td></td><td>Diag 1</td><td></td></tr>
    <tr class="even"><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $table->render());
  }

  function testRowStripingAdvanced() {
    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2', 'row3', 'row4', 'row5'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
      ->td('row3', 'col0', 'Diag 0')
      ->td('row4', 'col1', 'Diag 1')
      ->td('row5', 'col2', 'Diag 2')
      ->addRowClass('row1', 'extraClass')
      // Basic odd/even striping
      ->addRowStriping()
      // 3-way striping.
      ->addRowStriping(['1of3', NULL, '3of3'])
    ;

    $expected = <<<EOT
<table>
  <tbody>
    <tr class="odd 1of3"><td>Diag 0</td><td></td><td></td></tr>
    <tr class="extraClass even"><td></td><td>Diag 1</td><td></td></tr>
    <tr class="odd 3of3"><td></td><td></td><td>Diag 2</td></tr>
    <tr class="even 1of3"><td>Diag 0</td><td></td><td></td></tr>
    <tr class="odd"><td></td><td>Diag 1</td><td></td></tr>
    <tr class="even 3of3"><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

EOT;

    $this->assertEquals($expected, $table->render());
  }

} 
