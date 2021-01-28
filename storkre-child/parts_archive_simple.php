<?php global $url; ?>
<div class="top-post-list">
<?php // モバイルかつトップページの場合 ?>
<?php if (! is_paged() && is_mobile() && is_home()) { ?>
  <?php dynamic_sidebar('widget_sp_puread_home'); ?>
<?php } ?>
<?php // モバイルかつ一覧ページの場合 ?>
<?php if (is_mobile() && is_paged()) { ?>
  <?php dynamic_sidebar('widget_sp_puread_small'); ?>
<?php } ?>
<?php
  $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
  $ads_infeed = 8;
  $ads_infeed_count = 0;

  if (is_home() || is_front_page() || is_post_type_archive()) {
    $args = array(
      'post_type' => array('post', 'event'),
      'posts_per_page' => 16,
      'order' => 'DESC',
      'orderby' => 'date modified',
      'post_status' => 'publish',
      'paged' => $paged,
    );
  } elseif (is_archive()) {
    $post_type = get_post_type();
    $taxonomy_name = 'category';
    $cat_slug = [];
    $debug = 0;

    if ($post_type === 'post' && is_tag()) {
      $taxonomy_name = 'post_tag';
    }

    if ($post_type === 'event') {
      $taxonomy_name = 'event-category';
    }

    if (is_tax('event-category')) {
      $taxonomy_name = 'event-category';
    } elseif (is_tax('event-tag')) {
      $taxonomy_name = 'event-tag';
    } elseif (is_tax('event-venue')) {
      $taxonomy_name = 'event-venue';
    }

    if (isset($post->ID)) {
      $category = get_the_terms($post->ID, $taxonomy_name);
    }

    if (! empty($category)) {
      $cat_len = count($category);

      if (is_category()) {
        for($i = 0; $i < $cat_len; $i++) {
          if (is_category($category[$i]->slug)) {
            $cat_slug[$i] = $category[$i]->slug;
            break;
          }
        }
      } elseif (is_tax()) {
        for($i = 0; $i < $cat_len; $i++) {
          if (is_tax($taxonomy_name, $category[$i]->slug)) {
            $cat_slug[$i] = $category[$i]->slug;

            // スラッグをトリガーにクエリーを分岐させる
            if ($category[$i]->slug === 'collabo-period') {
              $period_flag = true;
              break;
            } elseif ($category[$i]->parent !== 0) {
              $cat_parent_id = $category[$i]->parent;
              $cat_parent = get_term($cat_parent_id, $taxonomy_name);

              if (! empty($cat_parent->description) && $cat_parent->slug === 'collabo-period') {
                $period_flag = true;
              }

              break;
            }
          }
        }
      }
    }

    if (empty($cat_slug)) {
      $url = $_SERVER['REQUEST_URI'];
      $path_arr = explode('/', $url);
      $path_count = count($path_arr);

      // 2以上なら
      if ($path_count >= 2) {
        if (array_values($path_arr) === $path_arr) {
          $cat_slug = $path_arr[$path_count - 2];
        }
      }
    }

    if (isset($period_flag) && $period_flag === true) {
      if (is_tax($taxonomy_name, 'collabo-period')) {
        // Local タイム取得
        $current_date = date('Y-m-d');
        // 文字に変換
        $current_date = strval($current_date);

        $args = array(
          'post_type' => array('post', 'event'),
          'posts_per_page' => 16,
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
              'terms' => $cat_slug,
              'field' => 'slug',
              'operator'=>'IN',
            ),
          ),
        );
      } else {
        $args = array(
          'post_type' => array('post', 'event'),
          'posts_per_page' => 16,
          'order' => 'ASC',
          'post_status' => 'publish',
          'paged' => $paged,
          'meta_key' => '_eventorganiser_schedule_start_start',
          'orderby'    => 'meta_value',
          'tax_query' => array(
            array(
              'taxonomy' => $taxonomy_name,
              'terms' => $cat_slug,
              'field' => 'slug',
              'operator'=>'IN',
            ),
          ),
        );
      }
    } else {

      if (is_author()) {
        $args = array(
          'post_type' => array('post', 'event'),
          'author' => $author,
          'posts_per_page' => 16,
          'order' => 'DESC',
          'orderby' => 'date modified',
          'post_status' => 'publish',
          'paged' => $paged,
        );
      } else {
        $args = array(
          'post_type' => array('post', 'event'),
          'posts_per_page' => 16,
          'order' => 'DESC',
          'orderby' => 'date modified',
          'post_status' => 'publish',
          'paged' => $paged,
          'tax_query' => array(
            array(
              'taxonomy' => $taxonomy_name,
              'terms' => $cat_slug,
              'field' => 'slug',
              'operator'=>'IN',
            ),
          ),
        );
      }
    }
  } elseif (is_search()) {
    $s = $_GET['s'];
    $args = array(
      's' => $s,
      'posts_per_page' => 16,
      'order' => 'DESC',
      'orderby' => 'date modified',
      'post_status' => 'publish',
      'paged' => $paged,
    );
    // Search Query
    $the_query = new WP_Query($args);
    // 検索を行い記事があったら
    if ($the_query->have_posts()) {

      while ($the_query->have_posts()) {
        $the_query->the_post();
        $cf = get_post_custom();
        $endless_flag = get_post_meta($post->ID, 'endless_event_flag', true);
        $ambiguous_period = get_post_meta($post->ID, 'ambiguous_ period', true);
        $other_period = get_post_meta($post->ID, 'other_period_text', true);
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

          if (! empty($start_date) && ! empty($end_date) && empty($date_dom)) {
            if ($endless_flag) {
              $date_dom .= $start_date . '〜';
            } else {
              $date_dom .= $start_date . '〜' . $end_date;
            }
          }

          // 期間が曖昧な時は上書き
          if ($ambiguous_period) {
            $date_dom = $ambiguous_period;
          }

          $terms = get_the_terms($post->ID, $taxonomy_name);
          $cat_name = get_the_work_term_name($terms);
        }
      ?>
        <article <?php post_class('post-list animated fadeIn search-container post__search'); ?> role="article">
          <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="cf">

            <?php if ( has_post_thumbnail()) { ?>
              <figure class="eyecatch">
                <?php the_post_thumbnail('home-thum', array('class' => 'lazy attachment-home-thum size-home-thum wp-post-image')); ?>
                <span class="cat-name"><?php echo $cat_name; ?></span>
              </figure>
            <?php } else { ?>
              <figure class="eyecatch noimg">
                <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
                <span class="cat-name"><?php echo $cat_name; ?></span>
              </figure>
          <?php } ?>
          <section class="entry-content remix">
            <h1 class="h2 entry-title"><?php the_title(); ?></h1>

            <p class="byline entry-meta vcard">
              <?php if (! empty($other_period)) { ?>
                <span class="event-date gf"><?php echo $other_period; ?></span>
              <?php } elseif (! empty($date_dom)) { ?>
                <span class="event-date gf">期間 : <?php echo $date_dom; ?></span>
              <?php } ?>
              <span class="date gf updated"><?php the_time('Y/m/d'); ?></span>
            </p>

            <?php if (! is_mobile()) { ?>
              <div class="description"><?php the_excerpt(); ?></div>
            <?php } ?>
          </section>
        </a>
      </article>
      <?php
      }
    ?>
  <?php } else { // 検索しても記事がなかったら ?>
    <article id="post-not-found" class="cf">
      <header class="article-header">
        <h1 class="entry-title">記事が見つかりませんでした。</h1>
      </header>
      <section class="entry-content">
        <p>お探しのキーワードで記事が見つかりませんでした。別のキーワードで再度お探しいただくか、カテゴリ一覧からお探し下さい。</p>
        <div class="search">
          <h2>キーワード検索</h2>
          <?php get_search_form(); ?>
        </div>


        <div class="cat-list cf">
          <h2>カテゴリーから探す</h2>
          <ul>
            <?php $args = array(
            'title_li' => '',
            ); ?>
            <?php wp_list_categories($args); ?>
          </ul>
        </div>
      </section>
    </article>
    <?php } ?>
  <?php }

  // TODO ごちゃごちゃしてきたからページ毎にテンプレート分ける
  if (! is_search()) {
    // Main Post
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
      while ($the_query->have_posts()) {
        $the_query->the_post();
        $cf = get_post_custom();
        $endless_flag = get_post_meta($post->ID, 'endless_event_flag', true);
        $ambiguous_period = get_post_meta($post->ID, 'ambiguous_ period', true);
        $other_period = get_post_meta($post->ID, 'other_period_text', true);

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

        if (! empty($start_date) && ! empty($end_date) && empty($date_dom)) {
          if ($endless_flag) {
            $date_dom .= $start_date . '〜';
          } else {
            $date_dom .= $start_date . '〜' . $end_date;
          }
        }

        if ($ambiguous_period) {
          $date_dom = $ambiguous_period;
        }

        $cat_name = '';
        $event_cat_slug = '';
        $cat = get_the_terms($post->ID, $taxonomy_name);
        $the_cat_length = count($cat);

        // タグページではカテゴリを表示する
        if (is_tax('event-tag')) {
          $cat = get_the_terms($post->ID, 'event-category');
        }

        $event_cat_slug = get_the_genre_name($cat);

        for ($i = 0; $i < $the_cat_length; $i++) {
          if ($event_cat_slug === $cat[$i]->slug) {
            $cat_name .= $cat[$i]->name;
            break;
          }
        }

        if (empty($cat_name) && $post_type === 'post') {
          $cat_name .= $cat[0]->name;
        }

        // Infeed広告
        if ($ads_infeed_count === $ads_infeed) { ?>
          <?php if (is_prod()) { ?>
            <div class="cc-infeed">
              <ins class="adsbygoogle"
                   style="display:block"
                   data-ad-format="fluid"
                   data-ad-layout="image-side"
                   data-ad-layout-key="-f0+6h+4r-et+9t"
                   data-ad-client="ca-pub-7307810455044245"
                   data-ad-slot="4912770015"></ins>
              <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
              </script>
            </div>
          <?php } ?>
        <?php }
          $ads_infeed_count++;

        // 期間別一覧の場合
        if (isset($period_flag)) { ?>
          <article <?php post_class('post-list period-list animated fadeIn'); ?> role="article">
            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="cf">
              <div class="byline entry-meta vcard">
                <?php if ($post_type === 'event') { ?>
                  <div class="event-date-parent">
                    <span class="event-cat cat-name term-slug__<?php echo $event_cat_slug; ?>"><?php echo $cat_name; ?></span>
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
                  <?php the_post_thumbnail('full', array('class' => 'lazy attachment-post-thumbnail size-post-thumbnail wp-post-image')); ?>
                </figure>
              <?php } else { ?>
                <figure class="eyecatch noimg">
                  <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
                </figure>
              <?php } ?>

              <section class="entry-content remix">
                <h1 class="h2 entry-title" rel="bookmark"><?php the_title(); ?></h1>

                <?php if (! is_mobile()) { ?>
                  <div class="description"><?php the_excerpt(); ?></div>
                <?php } ?>
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
        <?php } else { // トップページの新着一覧 ?>
          <article <?php post_class('post-list animated fadeIn'); ?> role="article">
            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="cf">

              <?php if ( has_post_thumbnail()) { ?>
                <figure class="eyecatch">
                  <?php // NOTE: 引数にclassを指定し、「lazy」classをつけると遅延読み込みの対象にする ?>
                  <?php the_post_thumbnail('home-thum', array('class' => 'lazy attachment-home-thum size-home-thum wp-post-image')); ?>
                  <span class="cat-name cat__name__home"><?php echo $cat_name; ?></span>
                </figure>
              <?php } else { ?>
                <figure class="eyecatch noimg">
                  <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
                  <span class="cat-name cat__name__none"><?php echo $cat_name; ?></span>
                </figure>
              <?php } ?>

              <section class="entry-content remix">
                <h1 class="h2 entry-title" rel="bookmark"><?php the_title(); ?></h1>

                <p class="byline entry-meta vcard">
                  <?php if ($post_type === 'event') { ?>
                    <?php if (! empty($other_period)) { ?>
                      <span class="event-icon gf"><?php echo $other_period; ?></span>
                    <?php } elseif (! empty($date_dom)) { ?>
                      <span class="event-date gf">期間 : <?php echo $date_dom; ?></span>
                    <?php } ?>
                  <?php } ?>
                  <span class="date gf updated"><?php the_time('Y/m/d'); ?></span>
                  <span class="author name entry-author">
                  <span class="fn"><?php the_author_meta('nickname'); ?></span>
                  </span>
                </p>

                <?php if (! is_mobile()) { ?>
                  <div class="description"><?php the_excerpt(); ?></div>
                <?php } ?>
              </section>
              <?php
                if (is_user_logged_in()) { ?>
                <div class="cc-logged-user">
                  <p class="cc-logged-user__panel">ログインユーザーのみ表示</p>
                  <div class="cc-logged-user__information">記事公開時間: <?php the_time("Y年m月d日 H時i分s秒"); ?></div>
                </div>
              <?php } ?>
            </a>
          </article>
      <?php } ?>
    <?php } // end while the_post();
    } else { ?>
      <article id="post-not-found" class="hentry cf">
        <header class="article-header">
          <h1>まだ投稿がありません！</h1>
        </header>
        <section class="entry-content">
          <p>表示する記事がまだありません。</p>
        </section>
      </article>
  <?php } // end Main Loop
  } // end ! is_search()
  if (! function_exists('wp_pagenavi')) {
    // Original Pagination
    pagination();
  } else {
    // Pagination Plugin
    wp_pagenavi(array('query' => $the_query));
  }
  // Reset WP_Query
  wp_reset_postdata(); ?>
</div><?php // end div.top-post-list ?>
