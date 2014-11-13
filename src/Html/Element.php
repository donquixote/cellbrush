<?php


namespace Donquixote\Cellbrush\Html;


class Element implements ElementInterface {

  use AttributesTrait;

  /**
   * @var string
   *   E.g. 'td' or 'th' or 'div'.
   */
  private $tagName;

  /**
   * The inner html.
   *
   * @var string
   */
  private $content;

  /**
   * @param string $tagName
   * @param string $content;
   */
  function __construct($tagName, $content = '') {
    $this->tagName = $tagName;
    $this->content = $content;
  }

  /**
   * @return string
   */
  function render() {
    return $this->renderTag($this->tagName, $this->content);
  }
}
