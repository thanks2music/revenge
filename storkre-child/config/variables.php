<?php
  global $is_sp, $is_pc, $url, $dir, $amp_flag;

  $dir = [];
  $url = [];
  $amp_flag = false;

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
  $url['home'] = esc_url(home_url());
  $url['appstore'] = 'https://apps.apple.com/jp/app/id1481548251/';
  $url['googleplay'] = 'https://play.google.com/store/apps/details?id=com.collabo_cafe.app';

  if (is_single() && $_GET['amp'] === '1') {
    $amp_flag = true;
  }
?>
