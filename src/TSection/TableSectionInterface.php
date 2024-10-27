<?php

namespace Donquixote\Cellbrush\TSection;

use Donquixote\Cellbrush\Columns\ColumnClassesInterface;
use Donquixote\Cellbrush\Html\MutableAttributesInterface;

/**
 * Interface for a table section element.
 */
interface TableSectionInterface extends ColumnClassesInterface, MutableAttributesInterface, TableSectionStructureInterface {

}
