<!doctype html>
<?php
  global $is_sp, $is_pc, $amp_flag;
?>
  <html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title(''); ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <meta name="HandheldFriendly" content="True">
    <?php get_template_part('head'); ?>
    <?php if (is_prod()) { ?>
      <?php get_template_part('partials/adx'); ?>
    <?php } ?>
    <?php wp_head(); ?>
  </head>
  <?php
    $body_class = '';
    $event_taxonomy_cat = 'event-category';
    if ($is_sp) {
      $body_class .= 'app sp no-amp';
    } else {
      $body_class .= 'pc';
    }

    if (is_tax($event_taxonomy_cat, 'collabo-period')) {
      $terms = get_the_terms($post->ID, $event_taxonomy_cat);
      $term_len = count($terms);

      for($i = 0; $i < $term_len; $i++) {
        if (! empty($terms[$i]->description)) {
          $des = $terms[$i]->description;
        }

        // 親カテゴリがあったら
        // for 期間別一覧の子カテゴリ
        if ($terms[$i]->parent !== 0) {
          // 親の情報を取得
          $term_parent_id = $terms[$i]->parent;
          $term_parent = get_term($term_parent_id, $event_taxonomy_cat);
          $parent_des = $term_parent->description;

          // 親カテゴリの紹介文があるか
          if (isset($parent_des) && $parent_des === 'common') {
            $body_class .= ' period child-period';
          }
        }

        // 期間別一覧の場合
        // 紹介文で分岐
        if (isset($des) && $des === 'common') {
          $body_class .= ' period';
        }
      }
    }
  ?>
  <body <?php body_class($body_class); ?>>
    <?php get_template_part('partials/meta/gtm'); ?>
    <div id="container" class="app__container">

