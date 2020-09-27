<?php
  global $amp_flag, $is_sp, $is_pc;
  // 開催期間別一覧をフッター下部に追加
  $show_period_flag = true;
  $post_type = get_post_type();
  $taxonomy_name = 'event-category';
  // Taxonomy設定
  if ($post_type === 'event') {
    if (is_tax('event-category')) {
      $taxonomy_name = 'event-category';
    } elseif (is_tax('event-tag')) {
      $taxonomy_name = 'event-tag';
    }
  }

  // Terms取得
  $category = get_the_terms($post->ID, $taxonomy_name);
  if (! empty($category)) {
    $cat_len = count($category);
    // 特定のTermページか分岐
    for($i = 0; $i < $cat_len; $i++) {
      if (is_tax($taxonomy_name, $category[$i]->slug)) {
        $cat_slug[$i] = $category[$i]->slug;

        // スラッグをトリガーにクエリーを分岐させる
        if ($category[$i]->slug === 'collabo-period') {
          // Taxonomyページの場合、開催期間別一覧にだけ表示させない
          $show_period_flag = false;
          break;
          // 親カテゴリがあったら
        } elseif ($category[$i]->parent !== 0) {
          $cat_parent_id = $category[$i]->parent;
          $cat_parent = get_term($cat_parent_id, $taxonomy_name);

          if (! empty($cat_parent->description) && $cat_parent->slug === 'collabo-period') {
            $show_period_flag = false;
          }

          break;
        }
      }
    }
  }
?>
<div id="page-top">
  <a href="#header" title="ページトップへ"><i class="fa fa-chevron-up"></i></a>
</div>
<?php if(!is_singular( 'post_lp' ) ): ?>
<div id="footer-top" class="wow animated fadeIn cf <?php echo get_option('side_options_headerbg');?>">
  <div class="inner wrap cf">
    <?php if ( is_mobile() && is_active_sidebar( 'footer-sp' )) : ?>
    <?php dynamic_sidebar( 'footer-sp' ); ?>
    <?php else:?>
    <?php if ( is_active_sidebar( 'footer1' ) ) : ?>
      <div class="m-all t-1of2 d-1of3">
      <?php dynamic_sidebar( 'footer1' ); ?>
      </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'footer2' ) ) : ?>
      <div class="m-all t-1of2 d-1of3">
      <?php dynamic_sidebar( 'footer2' ); ?>
      </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'footer3' ) ) : ?>
      <div class="m-all t-1of2 d-1of3">
      <?php dynamic_sidebar( 'footer3' ); ?>
      </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<footer id="footer" class="footer <?php echo get_option('side_options_headerbg');?>" role="contentinfo">
  <div id="inner-footer" class="inner wrap cf">
    <nav role="navigation">
<?php wp_nav_menu(array(
  'container' => 'div',
  'container_class' => 'footer-links cf',
  'menu' => __( 'Footer Links' ),
  'menu_class' => 'footer-nav cf',
  'theme_location' => 'footer-links',
  'before' => '',
  'after' => '',
  'link_before' => '',
  'link_after' => '',
  'depth' => 0,
  'fallback_cb' => ''
)); ?>
    </nav>
    <div class="footer__copyright">
      &copy; <?php echo date('Y'); ?> <?php dynamic_sidebar('common_copyright'); ?>
    </div>
  </div>
</footer>
</div>
<?php if (! $amp_flag) {
wp_footer();
}
?>
</body>
</html>
