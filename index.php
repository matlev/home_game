<?php

include('include/db/db_conn.php');

//$result_set = db_query("SELECT * FROM users");
//$result = $result_set->fetch_assoc();
//
//var_dump($result);

// Function to build head element
global $js;
global $css;

if ($js == NULL) {
  $js = array();
}
if ($css == NULL) {
  $css = array();
}

function getDirContents($dir) {
  global $js;
  global $css;

  $files = scandir($dir);

  foreach ($files as $key => $value) {
    $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

    if (!is_dir($path)) {
      $path_parts = explode('.', $path);
      $file_extension = array_pop($path_parts);

      if ($file_extension == 'js') {
        $js[] = substr($path, strlen(__DIR__) + 1);
      } elseif ($file_extension == 'css') {
        $css[] = substr($path, strlen(__DIR__) + 1);
      }
    } elseif ($value[0] != '.') {
      getDirContents($path);
    }
  }
}

if (NULL == $js && NULL == $css) {
  getDirContents('.' . DIRECTORY_SEPARATOR);
}

function add_scripts_to_head() {
  global $js;
  global $css;

  $css_scripts = '';
  $js_scripts = '';

  foreach ($js as $key => $value) {
    $js_scripts .= "<script src='$value'></script>";
  }

  foreach ($css as $key => $value) {
    $css_scripts .= "<link rel='stylesheet' type='text/css' href='$value'>";
  }

  echo $js_scripts;
  echo $css_scripts;
}
?>

<html>
  <head>
    <title>Main Game Page</title>
    <?php
      add_scripts_to_head();
    ?>
  </head>

  <body>
    <p>Hello World!</p>
  </body>
</html>
