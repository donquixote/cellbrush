
# Cellbrush table generator

A library to generate HTML tables with PHP.

Features:

* Named rows and columns.
* Colspan and rowspan using col groups and row groups.
* Automatically fills up empty cells.

## Basic usage

A simple 3x3 table with the diagonal cells filled. 

    $table = (new \Donquixote\Cellbrush\Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['col0', 'col1', 'col2'])
      ->td('row0', 'col0', 'Diag 0')
      ->td('row1', 'col1', 'Diag 1')
      ->td('row2', 'col2', 'Diag 2')
    ;
    $html = $table->render();

<table>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td></tr>
    <tr><td></td><td>Diag 1</td><td></td></tr>
    <tr><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

## Cells in thead and tfoot

A table like above, but with added thead section.

Column names are shared between table sections, but new rows need to be defined for each section.

    $table = ...
    $table->thead()
      ->addRowName('head row')
      ->th('head row', 'col0', 'H0')
      ->th('head row', 'col1', 'H1')
      ->th('head row', 'col2', 'H2')
    ;
    $html = $table->render();

<table>
  <thead>
    <tr><th>H0</th><th>H1</th><th>H2</th></tr>
  </thead>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td></tr>
    <tr><td></td><td>Diag 1</td><td></td></tr>
    <tr><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

## Additional tbody sections

By default, every addRowName() and td() or th() goes into the main tbody section.

So, the following two are equivalent:

    $table->td('row0', 'col0', 'Cell contents');
    $table->tbody()->td('row0', 'col0', 'Cell contents');

More named tbody sections can be added like this:

    $table->tbody('tb1')
      ->addRowName(..)
      ->td(..)

Again, the column definitions are shared between table sections, but row
definitions need to be added separately.


## Full rowspan and colspan

To let a cell span the entire width of the table, simply set the column name to ''.
Likewise, set the row name to '' to span the entire height of the table section.

    $table->thead()
      ->addRowName('head row')
      ->td('head row', '', 'Horizontal cell in thead.')
    ;
    $table
      ->...
      ->td('', 'col1', 'Vertical cell')
    ;

## Column groups

Named column groups allow for cells with colspan.
In the below example, the column name "products" specifies a colspan cell that spans all 3 products.* cells, whereas "products.a", "products.b" and "products.c" specifies specific cells without colspan. 

    $table
      ->addColName('legend')
      ->addColGroup('products', ['a', 'b', 'c'])
    ;
    $table->thead()
      ->addRowName('head')
      ->th('head', 'legend', 'Legend')
      // The "Products" label will span 3 columns: products.a, products.b, products.c
      ->th('head', 'products', 'Products')
      ->addRowName('name')
      ->th('name', 'legend', 'Product name')
      ->th('name', 'products.a', 'Product A')
      ->th('name', 'products.b', 'Product B')
      ->th('name', 'products.c', 'Product C')
    ;
    $table
      ->addRowName('width')
      ->td('width', 'products.a', '55 cm')
      ->td('width', 'products.b', '102 cm')
      ..
      ->addRowName('height')
      ..
      ->addRowName('price')
      ->td('price', 'products.a', '7.66 EUR')


## Row handles and column handles

RowHandle and \*ColHandle allow you to omit one of $rowName and $colName to address a table cell.

    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['legend', 'col0', 'col1', 'col2'])
      ...
    ;
    // Add cells in a "head0" row in the thead section.
    $table->thead()->addRow('head0')
      ->th('col0', 'Column 0')
      ->th('col1', 'Column 1')
      ->th('col2', 'Column 2')
    ;
    // Add cells in a "legend" column.
    $table->colHandle('legend')
      ->th('row0', 'Row 0')
      ->th('row1', 'Row 1')
      ->th('row2', 'Row 2')
    ;

<table>
  <thead>
    <tr><th>H0</th><th>H1</th><th>H2</th></tr>
  </thead>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td></tr>
    <tr><td></td><td>Diag 1</td><td></td></tr>
    <tr><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

## More examples?

You can see more examples in [the unit tests](https://github.com/donquixote/cellbrush/tree/master/tests/src).

## Planned features

Next steps:

* Row groups, analogous to col groups. I simply did not have the time for this yet.
* Combinations of row group and col groups.
* Nested groups.
* More options to set html tag attributes on td/th, tr, tbdody/thead/tfoot, and the table itself.
