<?php


namespace Donquixote\Cellbrush\Html;

class Tag implements TagInterface {

  use AttributesTrait;

  /**
   * @var string
   *   E.g. 'td' or 'th' or 'div'.
   */
  private $tagName;

  /**
   * @param string $tagName
   */
  function __construct($tagName) {
    $this->tagName = $tagName;
  }

  /**
   * @param string $content
   *
   * @return string
   */
  function renderWithContent($content) {
    return $this->renderTag($this->tagName, $content);
  }
}
