<?php
/**
 * Created by PhpStorm.
 * User: lemonhead
 * Date: 11/12/14
 * Time: 9:40 PM
 */

namespace Donquixote\Cellbrush\Html;


interface TagInterface extends AttributesBuilderInterface {

  /**
   * @param string $content
   *
   * @return string
   */
  function renderWithContent($content);
}
