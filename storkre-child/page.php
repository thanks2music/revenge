<?php
  $cf = get_post_custom();
  $app_body = $cf['app_field'][0];
  $app_only_flag = $cf['app_only'][0];

  if (is_app()) {
    echo nl2br($app_body);
    // is_web
  } else {
    if ($app_only_flag) {
      // webでは表示しない
      exit;
    } else { ?>
      <?php get_header(); ?>
      <div id="content">
        <div id="inner-content" class="wrap cf">
          <main id="main" class="m-all t-all d-5of7 cf" role="main">
            <?php get_template_part( 'parts_add_top' ); ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
              <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
                <header class="article-header entry-header">
                  <h1 class="entry-title page-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>
                  <?php if ( has_post_thumbnail() && !get_option( 'post_options_eyecatch' ) ) :?>
                    <figure class="eyecatch">
                    <?php the_post_thumbnail(); ?>
                    </figure>
                  <?php endif; ?>
                  <?php if ( !get_option( 'sns_options_hide' ) &&!is_home() && !is_front_page() && get_option( 'sns_options_page' )) : ?>
                    <?php get_template_part( 'parts_sns_short' ); ?>
                  <?php endif; ?>
                </header>
                <section class="entry-content cf">
                <?php
                  if (is_page('title-name-list')) {
                    get_template_part('partials/page/sort-term-slug');
                  } else {
                    // 通常ページ
                    the_content();
                  }
                ?>
                </section>
              <?php if ( !get_option( 'sns_options_hide' ) &&!is_home() && !is_front_page() && get_option( 'sns_options_page' )) : ?>
              <footer class="article-footer">
              <div class="sharewrap wow animated fadeIn" data-wow-delay="0.5s">
              <?php if ( get_option( 'sns_options_text' ) ) : ?>
              <h3><?php echo get_option( 'sns_options_text' ); ?></h3>
              <?php endif; ?>
              <?php get_template_part( 'parts_sns' ); ?>
              </div>
              </footer>
              <?php endif; ?>

              <?php if ( is_active_sidebar( 'cta' ) && get_option('post_options_page_cta') ) : ?>
              <div class="cta-wrap wow animated fadeIn" data-wow-delay="0.7s">
              <?php dynamic_sidebar( 'cta' ); ?>
              </div>
              <?php endif; ?>

              </article>
            <?php endwhile; endif; ?>
            <?php get_template_part( 'parts_add_bottom' ); ?>
          </main>
        <?php get_sidebar(); ?>
        </div>
      </div>
      <?php get_footer(); ?>
    <?php
    }
  }
?>
