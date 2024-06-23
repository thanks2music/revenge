<?php
global $is_sp, $is_pc, $amp_flag;
$post_class = 'app__single'
?>

<?php get_header('app'); ?>
<div id="single__container" class="single__container">
  <div id="content" class="app__single__container">
    <div id="inner-content" class="wrap cf">
      <main id="main" class="m-all t-all d-5of7 cf" role="main">
        <?php while (have_posts()) {
          the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?> role="article">
          <?php dynamic_sidebar( 'addbanner-titletop' ); ?>
          <header class="article-header entry-header">
          <p class="byline entry-meta cf">
            <?php if (is_singular('post')) {
              $cat = get_the_category();
              $cat = $cat[0];
            } ?>

            <?php if(is_singular('post')):?><span class="cat-name cat-id-<?php echo $cat->cat_ID;?>"><?php echo $cat->name; ?></span><?php endif;?>
            <?php
              $time_class_publish = 'date gf entry-date published';
              // 編集時間のが大きかったら
              if (get_the_date('Ymd') < get_the_modified_date('Ymd')) {
                // 編集していなかったら
              } else {
                $time_class_publish .= ' updated';
              }
            ?>
            <time class="<?php echo $time_class_publish; ?>"<?php if ( get_the_date('Ymd') >= get_the_modified_date('Ymd') ) : ?>  datetime="<?php echo get_the_date('Y-m-d') ?>"<?php endif; ?>><?php echo get_the_date('Y.m.d'); ?></time>
            <?php if (get_the_date('Ymd') < get_the_modified_date('Ymd')) { ?>
              <time class="date gf entry-date undo updated sr-only" datetime="<?php echo get_the_modified_date( 'Y-m-d' ) ?>"><?php echo get_the_modified_date('Y.m.d') ?></time>
            <?php } ?>
          </p>

          <h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

          <?php if ( has_post_thumbnail() && !get_option( 'post_options_eyecatch' ) ) :?>
          <figure class="eyecatch">
          <?php // NOTE: 引数にclassを指定し、「lazy」classをつけると遅延読み込みの対象にする。アイキャッチ画像は最初に表示させたいので遅延ロード行わない ?>
          <?php the_post_thumbnail('full', array('class' => 'size-full wp-image wp-eyecatch')); ?>
          </figure>
          <?php endif; ?>
          </header>


          <?php if ( is_active_sidebar( 'addbanner-sp-titleunder' ) ) : ?>
            <?php if ( wp_is_mobile() ) : ?>
              <div class="ad__title-under">
                <?php dynamic_sidebar( 'addbanner-sp-titleunder' ); ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <section class="entry-content cf">
          <?php
            // フィルターを通してthe_contentを呼び出す
            $the_content = apply_filters('the_content', get_the_content());
            echo $the_content;

            page_nav_singular();
            ?>

            <div class="entry__author">
              <?php get_template_part('partials/author'); ?>
            </div>

            <div class="entry__detail">
              <?php get_template_part( 'event-meta-event-single' ); ?>
            </div>

            <p class="entry-author vcard author">
              <span class="writer name fn"><?php the_author_meta('nickname'); ?></span>
            </p>
          </section>

          <?php if (is_active_sidebar('addbanner-sp-contentfoot') && is_mobile()) : ?>
            <div class="ad__sp-content">
              <?php dynamic_sidebar('addbanner-sp-contentfoot'); ?>
            </div>
          <?php endif; ?>
          </article>

          <div class="app__single__after">
            <div class="widget_text widget widget_custom_html">
              <h4 class="widgettitle">人気ランキング</h4>
              <div class="textwidget custom-html-widget">
                <?php echo do_shortcode('[wpp range="last3days" order_by="views" post_type="event" limit="10" thumbnail_width="140" thumbnail_height="80" stats_views="0"]'); ?>
              </div>
            </div>

            <?php get_template_part('gad-related'); ?>

            <?php // TODO 新着一覧もつける ?>
          </div>
          <?php
          } // end while
        ?>
      </main>
    </div>
  </div>
</div>
<?php wp_reset_postdata(); ?>
<?php get_footer('app'); ?>
