[![Build Status](https://secure.travis-ci.org/donquixote/cellbrush.png)](https://travis-ci.org/donquixote/cellbrush)

# Cellbrush table generator

A library to generate HTML tables with PHP.

Table structure:

* Named rows and columns, so they can be targeted with string keys.
* Colspan and rowspan using col groups and row groups.
* Automatically fills up empty cells, to preserve the structural integrity.
* Automatically warns on cell collisions.

Tag attributes:

* Easily add row classes.
* Easily add row striping classes (odd/even zebra striping and more).
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

```php
$table = \Donquixote\Cellbrush\Table\Table::create()
  ->addRowNames(['row0', 'row1', 'row2'])
  ->addColNames(['col0', 'col1', 'col2'])
  ->td('row0', 'col0', 'Diag 0')
  ->td('row1', 'col1', 'Diag 1')
  ->td('row2', 'col2', 'Diag 2')
;
$html = $table->render();
```

<table>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td></tr>
    <tr><td></td><td>Diag 1</td><td></td></tr>
    <tr><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

Too verbose? Look for "Shortcut syntax" below.

## Cells in thead and tfoot

A table like above, but with added thead section.

Column names are shared between table sections, but new rows need to be defined for each section.

```php
$table = ...
$table->thead()
  ->addRowName('head row')
  ->th('head row', 'col0', 'H0')
  ->th('head row', 'col1', 'H1')
  ->th('head row', 'col2', 'H2')
;
$html = $table->render();
```

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

```php
$table->td('row0', 'col0', 'Cell contents');
$table->tbody()->td('row0', 'col0', 'Cell contents');
```

More named tbody sections can be added like this:

```php
$table->tbody('tb1')
  ->addRowName(..)
  ->td(..)
```

Again, the column definitions are shared between table sections, but row
definitions need to be added separately.


## Full rowspan and colspan

To let a cell span the entire width of the table, simply set the column name to ''.
Likewise, set the row name to '' to span the entire height of the table section.

```php
$table->thead()
  ->addRowName('head row')
  ->td('head row', '', 'Horizontal cell in thead.')
;
$table
  ->...
  ->td('', 'col1', 'Vertical cell')
;
```

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

```php
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
```

<table>
  <thead>
    <tr><th>Legend</th><th colspan="3">Products</th></tr>
    <tr><th>Product name</th><th>Product A</th><th>Product B</th><th>Product C</th></tr>
  </thead>
  <tbody>
    <tr><th>Width</th><td>55 cm</td><td>102 cm</td><td>7 cm</td></tr>
  </tbody>
</table>


## Row groups

Similar to column groups.

```php
$table = Table::create()
  ->addColNames(['legend', 'sublegend', 0, 1])
  ->addRowGroup('dimensions', ['width', 'height'])
  ->addRowName('price')
  ->th('dimensions', 'legend', 'Dimensions')
  ->th('dimensions.width', 'sublegend', 'Width')
  ->th('dimensions.height', 'sublegend', 'Height')
  ->th('price', 'legend', 'Price')
;
$table->headRow()->thMultiple(['Product 0', 'Product 1']);
$table->rowHandle('dimensions.width')->tdMultiple(['2cm', '5cm']);
$table->rowHandle('dimensions.height')->tdMultiple(['14g', '22g']);
$table->rowHandle('price')->tdMultiple(['7,- EUR', '5,22 EUR']);
```

<table>
  <thead>
    <tr><td></td><td></td><th>Product 0</th><th>Product 1</th></tr>
  </thead>
  <tbody>
    <tr><th rowspan="2">Dimensions</th><th>Width</th><td>2cm</td><td>5cm</td></tr>
    <tr><th>Height</th><td>14g</td><td>22g</td></tr>
    <tr><th>Price</th><td></td><td>7,- EUR</td><td>5,22 EUR</td></tr>
  </tbody>
</table>

## Combination of row groups and column groups

```php
$table = (new Table())
  ->addColName('name')
  ->addColGroup('info', ['color', 'price'])
  ->addRowGroup('banana', ['description', 'info'])
  ->th('banana', 'name', 'Banana')
  ->td('banana.description', 'info', 'A yellow fruit.')
  ->td('banana.info', 'info.color', 'yellow')
  ->td('banana.info', 'info.price', '60 cent')
  ->addRowGroup('coconut', ['description', 'info'])
  ->th('coconut', 'name', 'Coconut')
  ->td('coconut.description', 'info', 'Has liquid inside.')
  ->td('coconut.info', 'info.color', 'brown')
  ->td('coconut.info', 'info.price', '3 dollar')
;
$table->headRow()
  ->th('name', 'Name')
  ->th('info.color', 'Color')
  ->th('info.price', 'Price')
;
```

<table>
  <thead>
    <tr><th>Name</th><th>Color</th><th>Price</th></tr>
  </thead>
  <tbody>
    <tr><th rowspan="2">Banana</th><td colspan="2">A yellow fruit.</td></tr>
    <tr><td>yellow</td><td>60 cent</td></tr>
    <tr><th rowspan="2">Coconut</th><td colspan="2">Has liquid inside.</td></tr>
    <tr><td>brown</td><td>3 dollar</td></tr>
  </tbody>
</table>

## Nested groups

Groups can have unlimited depth.

```php
$table = Table::create()
  ->addRowNames(['T', 'B.T', 'B.B.T', 'B.B.B'])
  ->addColNames(['L', 'R.L', 'R.R.L', 'R.R.R'])
  ->td('T', '', 'top')
  ->td('B', 'L', 'bottom left')
  ->td('B.T', 'R', 'B.T / R')
  ->td('B.B', 'R.L', 'B.B / R.L')
  ->td('B.B.T', 'R.R', 'B.B.T / R.R')
  ->td('B.B.B', 'R.R.L', 'B.B.B / R.R.L')
  ->td('B.B.B', 'R.R.R', 'B.B.B / R.R.R')
;
```

<table>
  <tbody>
    <tr><td colspan="4">top</td></tr>
    <tr><td rowspan="3">bottom left</td><td colspan="3">B.T / R</td></tr>
    <tr><td rowspan="2">B.B / R.L</td><td colspan="2">B.B.T / R.R</td></tr>
    <tr><td>B.B.B / R.R.L</td><td>B.B.B / R.R.R</td></tr>
  </tbody>
</table>

## Open-ended cells

Open-end cells allow overlapping colspan cells, like bricks in a wall.

```php
$table = (new Table())->addColNames([0, 1, 2, 3, 4, 5, 6, 7]);
$table->addRow(0)->tdMultiple([0, 1, 2, 3, 4, 5, 6, 7]);
$table->addRow(1)
  ->tdOpenEnd(0, '0..2')
  ->tdOpenEnd(3, '3..4')
  ->tdOpenEnd(5, '5')
  ->tdOpenEnd(6, '6..7')
;
$table->addRow(2)
  ->tdOpenEnd(0, '0..1')
  ->tdOpenEnd(2, '2..3')
  ->tdOpenEnd(4, '4..6')
  ->tdOpenEnd(7, '7')
;
```

<table>
  <tbody>
    <tr>
      <td>0</td>
      <td>1</td>
      <td>2</td>
      <td>3</td>
      <td>4</td>
      <td>5</td>
      <td>6</td>
      <td>7</td>
    </tr>
    <tr>
      <td colspan="3">0..2</td>
      <td colspan="2">3..4</td>
      <td>5</td>
      <td colspan="2">6..7</td>
    </tr>
    <tr>
      <td colspan="2">0..1</td>
      <td colspan="2">2..3</td>
      <td colspan="3">4..6</td>
      <td>7</td>
    </tr>
  </tbody>
</table>


## Shortcut syntax with row handles and column handles

RowHandle and \*ColHandle allow you to omit one of $rowName and $colName to address a table cell.

```php
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
```

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

```php
$table->addRowClass('row0', 'rowClass0');
```

## Row striping

Row striping classes can be added to a table section with `addRowStriping()`.

The default striping is `['odd', 'even']`, but different patterns can be added with three or more stripes.

```php
// Odd/even zebra striping.
$table->addRowStriping();
// 3-way striping.
$table->addRowStriping(['1of3', '2of3', '3of3']);
```

The striping always applies to a table section. By default, this wil be the main tbody section.


## Column classes

You can use `addColClass()` to add a class to all cells of a column.
This can be done either for all table sections at once, or for specific table sections.

```php
$table->addColClass('col0', 'allSectionsColumn0');
$table->tbody()->addColClass('col0', 'tbodyColumn0');
```

## Column Reordering

Columns can be reordered even after the cells are already added.

```php
// Create a table, and render it.
$table = Table::create()
  ->addRowNames(['row0', 'row1', 'row2'])
  ->addColNames(['col0', 'col1', 'col2'])
  ->td('row0', 'col0', 'Diag 0')
  ->td('row1', 'col1', 'Diag 1')
  ->td('row2', 'col2', 'Diag 2')
;
print $table->render();
```

<table>
  <tbody>
    <tr><td>Diag 0</td><td></td><td></td></tr>
    <tr><td></td><td>Diag 1</td><td></td></tr>
    <tr><td></td><td></td><td>Diag 2</td></tr>
  </tbody>
</table>

```php
// Reorder the columns, and render again.
$table->setColOrder(['col1', 'col2', 'col0']);
print $table->render();
```

<table>
  <tbody>
    <tr><td></td><td></td><td>Diag 0</td></tr>
    <tr><td>Diag 1</td><td></td><td></td></tr>
    <tr><td></td><td>Diag 2</td><td></td></tr>
  </tbody>
</table>

## More examples?

You can see more examples in [the unit tests](https://github.com/donquixote/cellbrush/tree/master/tests/src).

## Planned features

Next steps:

* Nested groups, more than one level deep.
* Brick-style ("overlapping") rowspan and colspan, e.g. to represent time intervals.
* More options to set html tag attributes and classes on td/th, tr, tbdody/thead/tfoot, and the table itself.
  Ideas and pull requests are welcome!
* Open-end cells. You only mark the top left, the rest will expand until it hits something.
* Reordering of rows and columns after the cells are filled.
* Insertion of new rows and columns after the cells are filled.
