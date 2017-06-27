<?php
  global $is_sp, $is_pc, $url, $dir;

  $dir = [];
  $url = [];

  // PC or SP判定
  if (wp_is_mobile()) {
    $is_sp = true;
    $is_pc = false;
  } else {
    $is_pc = true;
    $is_sp = false;
  }

  $dir['theme'] = get_stylesheet_directory_uri();
  $url['current'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
