<?php

require_once __DIR__ . '/vendor/autoload.php';

$kirby = kirby();

function is_localhost() {
  $whitelist = array( '127.0.0.1', '::1' );
  if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
      return true;
}
