<?php

namespace Donquixote\Cellbrush\Html;

interface TagInterface extends AttributesBuilderInterface {

  /**
   * @param string $content
   *
   * @return string
   */
  function renderWithContent($content);
}
