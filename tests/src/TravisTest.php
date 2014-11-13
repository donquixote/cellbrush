<?php


namespace Donquixote\Cellbrush\Tests;


use Donquixote\Cellbrush\Table\Table;

class TravisTest extends \PHPUnit_Framework_TestCase {

  function testTravisTraits() {
    new Table();
    $this->assertTrue(true);
  }
}
