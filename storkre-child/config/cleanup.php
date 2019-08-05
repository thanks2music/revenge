<?php
  // デフォルトタイムゾーン設定
  date_default_timezone_set('Asia/Tokyo');
  // Feedを停止
  remove_action('do_feed_rdf', 'do_feed_rdf');
  remove_action('do_feed_rss', 'do_feed_rss');
  remove_action('do_feed_rss2', 'do_feed_rss2');
  remove_action('do_feed_atom', 'do_feed_atom');
  // EditURIを消す
  remove_action('wp_head', 'rsd_link');
  // Windows Live Writerを消す
  remove_action('wp_head', 'wlwmanifest_link');
  // Version情報を表示しない
  remove_action('wp_head', 'wp_generator');
  // ショートカットURLを表示しない
  remove_action('wp_head', 'wp_shortlink_wp_head');
  // 絵文字関連情報を消す
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  // oEmbed情報を消す
  remove_action('wp_head','rest_output_link_wp_head');
  remove_action('wp_head','wp_oembed_add_discovery_links');
  remove_action('wp_head','wp_oembed_add_host_js');
?>
