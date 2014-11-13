<?php


namespace Donquixote\Cellbrush\Cell;


class PlaceholderCell extends Cell {

  function __construct() {
    parent::__construct('td', '');
  }
}
