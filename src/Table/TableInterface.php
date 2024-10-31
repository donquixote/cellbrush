<?php

namespace Donquixote\Cellbrush\Table;

use Donquixote\Cellbrush\Columns\ColumnAttributesInterface;
use Donquixote\Cellbrush\Columns\TableColumnsInterface;
use Donquixote\Cellbrush\Html\MutableAttributesInterface;
use Donquixote\Cellbrush\TSection\TableSectionStructureInterface;

interface TableInterface extends
  MutableAttributesInterface,
  TableSectionStructureInterface,
  TableColumnsInterface,
  ColumnAttributesInterface {

}
