<?php


namespace Donquixote\Cellbrush\Tests;


use Donquixote\Cellbrush\Axis\DynamicAxis;
use Donquixote\Cellbrush\TSection\TableSection;

class TableSectionTest extends \PHPUnit_Framework_TestCase {

  function testRegularTable() {
    $columns = new DynamicAxis();
    $columns->addNames(['c0', 'c1', 'c2']);
    $tsection = new TableSection($columns);
    $tsection->addRow('r0')
      ->td('c0', '00')
      ->td('c1', '01')
      ->td('c2', '02')
    ;
    $tsection->addRow('r1')
      ->td('c0', '10')
      ->td('c1', '11')
      ->td('c2', '12')
    ;
    # print_r($tsection->getRawMatrix($columns->takeSnapshot()));
  }

}
