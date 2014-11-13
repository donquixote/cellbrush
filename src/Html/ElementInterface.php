<?php

namespace Donquixote\Cellbrush\Html;

interface ElementInterface extends AttributesBuilderInterface {

  /**
   * @return string
   */
  function render();
}
