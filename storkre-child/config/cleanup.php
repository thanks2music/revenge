<?php
  // デフォルトタイムゾーン設定
  date_default_timezone_set('Asia/Tokyo');

  // Feedを停止
  remove_action('do_feed_rdf', 'do_feed_rdf');
  remove_action('do_feed_rss', 'do_feed_rss');
  remove_action('do_feed_rss2', 'do_feed_rss2');
  remove_action('do_feed_atom', 'do_feed_atom');
?>
