<?php

namespace Donquixote\Cellbrush;

class Util {

  /**
   * Inspired by Drupal's drupal_attributes().
   *
   * @param array $attributes
   *
   * @return string
   */
  static function htmlAttributes(array $attributes = array()) {
    foreach ($attributes as $attribute => &$data) {
      $data = implode(' ', (array) $data);
      $data = $attribute . '="' . self::checkPlain($data) . '"';
    }
    return $attributes ? ' ' . implode(' ', $attributes) : '';
  }

  /**
   * Inspired by Drupal's check_plain().
   *
   * @param string $text
   *
   * @return string
   */
  static function checkPlain($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }

}
