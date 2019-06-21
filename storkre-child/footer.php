<?php
  global $amp_flag;
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

  // 開催期間別
  if (isset($show_period_flag) && $show_period_flag === true) {
    global $is_pc;
    // Local タイム取得
    $current_date = date('Y-m-d');
    // 文字に変換
    $current_date = strval($current_date);
    $period_order = 10;

    if ($is_pc) {
      $period_order = 9;
    }

    $period_post_args = array(
      'post_type' => array('post', 'event'),
      'posts_per_page' => $period_order,
      'order' => 'ASC',
      'post_status' => 'publish',
      'paged' => $paged,
      'meta_key' => '_eventorganiser_schedule_start_finish',
      'meta_value' => $current_date,
      'meta_compare' => '>=',
      'orderby'    => 'meta_value',
      'tax_query' => array(
        array(
          'taxonomy' => $taxonomy_name,
          'terms' => 'collabo-period',
          'field' => 'slug',
          'operator'=>'IN',
        ),
      ),
    );

    // 記事取得
    $the_query = new WP_Query($period_post_args);

    // ループ開始
    if ($the_query->have_posts()) {
      $period_wrap_dom = '<div class="period-container">';
      $period_wrap_dom .= '<h3 class="headline-period">終了間近</h3>';
      echo $period_wrap_dom;

      while ($the_query->have_posts()) {
        $the_query->the_post();
        $cf = get_post_custom();
        $endless_flag = get_post_meta($post->ID, 'endless_event_flag', true);
        // 現在のpost_typeに上書き
        $post_type = get_post_type();
        $taxonomy_name = 'category';

        if ($post_type === 'event') {
          $start_date = '';
          $end_date = '';
          $date_dom = '';

          if (is_tax('event-category')) {
            $taxonomy_name = 'event-category';
          } elseif (is_tax('event-tag')) {
            $taxonomy_name = 'event-tag';
          } else {
            $taxonomy_name = 'event-category';
          }

          if (isset($cf['_eventorganiser_schedule_start_start'][0])) {
            $start_date = $cf['_eventorganiser_schedule_start_start'][0];
            $start_date = date('Y年n月j日', strtotime($start_date));
          }

          if (isset($cf['_eventorganiser_schedule_start_finish'][0])) {
            $end_date = $cf['_eventorganiser_schedule_start_finish'][0];
            $end_date = date('n月j日', strtotime($end_date));
          }
        }

        // 終わりがないイベントの場合
        if (! empty($start_date) && ! empty($end_date) && empty($date_dom)) {
          if ($endless_flag) {
            $date_dom .= $start_date . '〜';
          } else {
            $date_dom .= $start_date . '〜' . $end_date;
          }
        }

        // ループ内のカテゴリを取得
        $cat_name = '';
        $event_cat_slug = '';
        $cat = get_the_terms($post->ID, $taxonomy_name);
        $the_cat_length = count($cat);

        // カテゴリ名とスラッグを保存
        for ($i = 0; $i < $the_cat_length; $i++) {
          if ($cat[$i]->slug === 'cafe' || $cat[$i]->slug === 'event' || $cat[$i]->slug === 'news' || $cat[$i]->slug === 'karaoke') {
            $cat_name .= $cat[$i]->name;
            $event_cat_slug .= $cat[$i]->slug;
            break;
          }
        }

        // Just do it ?>
          <article <?php post_class('post-list period-list footer-period-list animated fadeIn'); ?> role="article">
            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="cf">
              <div class="byline entry-meta vcard">
                <?php if ($post_type === 'event') { ?>
                  <div class="event-date-parent">
                    <span class="event-cat cat-name term-slug-<?php echo $event_cat_slug; ?>"><?php echo $cat_name; ?></span>
                    <span class="event-date gf"><?php echo $date_dom; ?></span>
                  </div>
                <?php } ?>
                <span class="date gf updated"><?php the_time('Y/m/d'); ?></span>
                <span class="author name entry-author">
                  <span class="fn"><?php the_author_meta('nickname'); ?></span>
                </span>
              </div>
              <?php if ( has_post_thumbnail()) { ?>
                <figure class="eyecatch">
                  <?php // NOTE: 引数にclassを指定し、「lazy」classをつけると遅延読み込みの対象にする ?>
                  <?php the_post_thumbnail('period-thum', array('class' => 'lazy attachment-period-thum size-period-thum wp-post-image')); ?>
                </figure>
              <?php } else { ?>
                <figure class="eyecatch noimg">
                  <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
                </figure>
              <?php } ?>

              <section class="entry-content remix">
                <h1 class="h2 entry-title" rel="bookmark"><?php the_title(); ?></h1>

                  <?php if (! is_mobile()) {
                    $excerpt = get_the_excerpt();

                    if ($excerpt !== '' && ! empty($excerpt)) { ?>
                      <div class="description"><?php the_excerpt(); ?></div>
                    <?php }
                  } ?>
              </section>
            </a>
            <div class="enrty-tags">
              <?php // 開催期間別一覧のタグリスト
                $terms = get_the_terms($post->ID, 'event-tag');
                $term_len = count($terms);
                $dom = '';

                if (1 <= $term_len) {
                  for($i = 0; $i < $term_len; $i++) {
                    if ($i === 0) {
                      $dom .= '<ul>';
                    }

                    $name = $terms[$i]->name;
                    $link = get_term_link($terms[$i]);
                    $dom .= '<li><a href="' . $link . '">';
                    $dom .= $name . '</a></li>';

                    if ($i === $term_len - 1) {
                      $dom .= '</ul>';
                    }
                  }
                }

                echo $dom;
              ?>
            </div>
          </article>
        <?php
      } // end while
      $more_dom = '<a href="/events/category/collabo-period/" class="more-read-period">';
      $more_dom .= '終了間近の一覧' . '</a>';
      echo $more_dom;

      if ($is_pc) { ?>
      <div class="ad__footer__pc">
        <div class="ad__footer__pc__left">
          <!-- /21153358/68408 : CoCafe_PC_article_1st_left_68408 -->
          <div id="div-gpt-ad-1559874949947-0">
          <script>
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1559874949947-0'); });
          </script>
          </div>
        </div>
        <div class="ad__footer__pc__right">
          <!-- /21153358/68409 : CoCafe_PC_article_1st_right_68409-->
          <div id="div-gpt-ad-1559874975970-0">
          <script>
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1559874975970-0'); });
          </script>
          </div>
        </div>
      </div>
      <?php
      } else { ?>
        <div class="ad__adx__sp">
          <!-- /21153358/68389 : CoCafe_SP_all_footer_68389 -->
          <div id="div-gpt-ad-1559874477418-0">
            <script>
              googletag.cmd.push(function() { googletag.display('div-gpt-ad-1559874477418-0'); });
            </script>
          </div>
        </div>
      <?php }

      echo '</div>'; // end .period-container
    } // end if
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
