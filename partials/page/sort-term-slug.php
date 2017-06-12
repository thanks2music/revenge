<?php
  // get_termsにはデフォルト値がないので明示的に指定する
  $taxonomies = array('category', 'event-category');
  $args = array(
    // スラッグで
    'orderby'       => 'slug', 
    // 昇順
    'order'         => 'ASC',
    // 投稿のない空のタームは返さない
    'hide_empty'    => true, 
    // 除外したいターム
    'exclude'       => array(), 
    // 除外したいタームの親
    'exclude_tree'  => array(), 
    // 含めたいターム、デフォルトは空で全て
    'include'       => array(),
    // 含める数、デフォルトは全て
    'number'        => '', 
    // all で全ての情報
    'fields'        => 'all', 
    // (文字列|配列) 指定した値がスラッグに一致するタームを返す。デフォルトは空文字列
    'slug'          => '', 
    // (整数) 直近の子タームを返す（指定された値が親タームの ID であるタームのみ
    'parent'        => '',
    // (真偽値) 子タームを持つタームを含める（ 'hide_empty' が true のときでも）
    'hierarchical'  => true, 
    // (整数) 指定したタームの子孫をすべて取得します。デフォルトは 0 です
    'child_of'      => 0, 
    'childless'     => false,
    'get'           => '', 
    'name__like'    => '',
    'description__like' => '',
    'pad_counts'    => false, 
    'offset'        => '', 
    'search'        => '', 
    'cache_domain'  => 'core'
  ); 

  $terms = get_terms($taxonomies, $args);
  // $args = array(
  //   'post_type' => array('post', 'event'),
  //   'posts_per_page' => -1,
  //   'order' => 'DESC',
  //   'orderby' => 'meta_value',
  //   'meta_key' => 'furigana',
  // );
  // $query = new WP_Query($args);
  // while ($query->have_posts()) {
  //   $query->the_post();
  //   the_title();
  //   // get_template_part('partials/post/dom');
  // }
  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    $term_len = count($terms);
    $i = 0;
    $dom = '<ul id="anime-title-list" class="title-name-list">';

    foreach($terms as $term) {
      $i++;
      // リンク設定
      $dom .= '<li><a href="' . get_term_link($term) . '">';
      // 名前
      $dom .= $term->name . '</a></li>';
      // 一つずつ区切る
      if ($term_len !== $i) {
        $dom .= ' &middot; ';
      } // 最後の場合
      else {
        $dom .= 'hoge';
      }
    }

    $dom .= '</ul>';

    echo $dom;
  }
?>
