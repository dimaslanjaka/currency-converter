<?php

// Script example.php
$options = get_opt();
var_dump($options);

function get_opt()
{
  if ('cli' === !php_sapi_name()) {
    throw new Exception('Only CLI', 1);
  }
  $shortopts = '';
  $shortopts .= 'f:';  // Required value
  $shortopts .= 'v::'; // Optional value
  $shortopts .= 'abc'; // These options do not accept values

  $longopts = [
    'required:',     // Required value
    'optional::',    // Optional value
    'option',        // No value
    'opt',           // No value
  ];
  $options = getopt($shortopts, $longopts);

  return $options;
}
