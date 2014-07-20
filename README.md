
# Cellbrush table generator

A library to generate HTML tables with PHP.

Table structure:

* Named rows and columns, so they can be targeted with string keys.
* Colspan and rowspan using col groups and row groups.
* Automatically fills up empty cells, to preserve the structural integrity.
* Automatically warns on cell collisions.

Tag attributes:

* Easily add row classes.
* Easily add row striping classes (odd/even and more).
* Easily add column classes that apply to all cells in the column.
* (more planned)

API design:

* Method chaining instead of huge arrays of doom.
* Shortcut notations for frequently used stuff.
* Return value and parameter types nicely documented, so your IDE can let you know about possible operations.
* Exceptions thrown for integrity violation.
* Composer and PSR-4.


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

<table>
  <thead>
    <tr><td colspan="3">Horizontal cell in thead.</td></tr>
  </thead>
  <tbody>
    <tr><td>#</td><td rowspan="3">Vertical cell</td><td>#</td></tr>
    <tr><td>#</td><td>#</td></tr>
    <tr><td>#</td><td>#</td></tr>
  </tbody>
</table>

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
      ->th('width', 'legend', 'Width')
      ->td('width', 'products.a', '55 cm')
      ->td('width', 'products.b', '102 cm')
      ..
      ->addRowName('height')
      ..
      ->addRowName('price')
      ->td('price', 'products.a', '7.66 EUR')

<table>
  <thead>
    <tr><th>Legend</th><th colspan="3">Products</th></tr>
    <tr><th>Product name</th><th>Product A</th><th>Product B</th><th>Product C</th></tr>
  </thead>
  <tbody>
    <tr><th>Width</th><td>55 cm</td><td>102 cm</td><td>7 cm</td></tr>
  </tbody>
</table>


## Shortcut syntax with row handles and column handles

RowHandle and \*ColHandle allow you to omit one of $rowName and $colName to address a table cell.

    $table = (new Table())
      ->addRowNames(['row0', 'row1', 'row2'])
      ->addColNames(['legend', 'col0', 'col1', 'col2'])
      ...
    ;
    // Add cells in a "head0" row in the thead section.
    $table->headRow()
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
    <tr><td></td><th>Column 0</th><th>Column 1</th><th>Column 2</th></tr>
  </thead>
  <tbody>
    <tr><th>Row 0</th><td>Diag 0</td><td></td><td></td></tr>
    <tr><th>Row 1</th><td></td><td>Diag 1</td><td></td></tr>
    <tr><th>Row 2</th><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>


## Row classes

Row classes can be added quite easily with `addRowClass()`.

    $table->addRowClass('row0', 'rowClass0');

## Row striping

Row striping classes can be added to a table section with `addRowStriping()`.

The default striping is `['odd', 'even']`, but different patterns can be added with three or more stripes.

    $table->addRowStriping(['1of3', '2of3', '3of3']);


## Column classes

You can use `addColClass()` to add a class to all cells of a column.
This can be done either for all table sections at once, or for specific table sections.

    $table->addColClass('col0', 'allSectionsColumn0');
    $table->tbody()->addColClass('col0', 'tbodyColumn0');


## More examples?

You can see more examples in [the unit tests](https://github.com/donquixote/cellbrush/tree/master/tests/src).

## Planned features

Next steps:

* Row groups, analogous to col groups. I simply did not have the time for this yet.
* Combinations of row group and col groups.
* Nested groups.
* More options to set html tag attributes on td/th, tr, tbdody/thead/tfoot, and the table itself.
  Ideas and pull requests are welcome!
