<?php

namespace Donquixote\Cellbrush\Html;

interface MutableAttributesBuilderInterface {

  /**
   * @param string $class
   *
   * @return $this
   */
  function addClass($class);

  /**
   * @param string[] $classes
   *
   * @return $this
   */
  function addClasses(array $classes);

}
