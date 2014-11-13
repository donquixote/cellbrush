<?php
namespace Donquixote\Cellbrush\TSection;


/**
 * Interface for a collection of table rows.
 */
interface TableRowsInterface {

  /**
   * @param string $rowName
   *
   * @return $this
   * @throws \Exception
   */
  function addRowName($rowName);

  /**
   * @param string[] $rowNames
   *
   * @return $this
   */
  function addRowNames(array $rowNames);

  /**
   * @param string $rowName
   *
   * @return true
   */
  function rowExists($rowName);
}
