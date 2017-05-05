<?php

// 子テーマのstyle.cssを後から読み込む
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  global $dir;
  $time_stamp = time();
  wp_enqueue_style('style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style('child-style',
    $dir['theme'] . '/stylesheets/main.css?' . $time_stamp,
    array('style')
  );
}

// Global Variable
locate_template('config/variables.php', true);

// JavaScriptを指定する関数
add_action('wp_footer', 'add_javascripts');
function add_javascripts() {
  global $dir;
  wp_enqueue_script('app', $dir['theme'] . '/dist/scripts/app.js' );
}


// MOREタグの下に広告を表示
add_filter('the_content', 'adMoreReplace');
function adMoreReplace($contentData) {
  global $is_sp;
  $adTags = '';

  // SP
  if ($is_sp) {
$adTags = <<< EOF

<div class="add more">
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- CC - 記事の途中 -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="4994583614"
       data-ad-format="auto"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;
    // PC
  } else {
$adTags = <<< EOF

<div class="add more">
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- CC - PC記事の途中 -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="6789910818"
       data-ad-format="auto"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;
  }
  $contentData = preg_replace('/<p><span id="more-([0-9]+?)"><\/span>(.*?)<\/p>/i', $adTags, $contentData);
  $contentData = str_replace('<p></p>', '', $contentData);
  $contentData = str_replace('<p><br />', '<p>', $contentData);

  return $contentData;
}
