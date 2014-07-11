<?php

use Donquixote\Cellbrush\Table;

require_once __DIR__ . '/vendor/autoload.php';


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
    print $html;
