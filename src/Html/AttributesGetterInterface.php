<?php

namespace Donquixote\Cellbrush\Html;

interface AttributesGetterInterface {

  /**
   * @return string
   *   The string of all attributes, starting with a space.
   *   E.g. ' class="class0 class1" id="5"'
   */
  public function renderAttributes();

  /**
   * @param string $tagName
   * @param string $content
   *
   * @return string
   */
  public function renderTag($tagName, $content);

  /**
   * @param $tagName
   *
   * @return TagInterface
   */
  public function createTag($tagName);

}
