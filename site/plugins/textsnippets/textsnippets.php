<?php

// http://getkirby.com/docs/advanced/kirbytext
kirbytext::$pre[] = function($kirbytext, $value) {

  $snippets = c::get('kirbytext.snippets', array());
  $values   = array_values($snippets);
  $keys     = array_map(function($key) {
    return '{{' . $key . '}}';
  }, array_keys($snippets));

  return str_replace($keys, $values, $value);

};

?>