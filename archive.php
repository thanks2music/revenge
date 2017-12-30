<?php get_header(); ?>
<div id="content">
  <div id="inner-content" class="wrap cf">
    <main id="main" class="m-all t-all d-5of7 cf" role="main">
      <div class="archivettl">
        <?php if (is_archive() || is_post_type_archive()) { ?>
        <?php
          $post_type = get_post_type();
          $taxonomy_name = 'category';
          $cat_name = '';

          if ($post_type === 'event') {
            if (is_tax('event-category')) {
              $taxonomy_name = 'event-category';
            } elseif (is_tax('event-tag')) {
              $taxonomy_name = 'event-tag';
            }

            $cat_name .= 'コラボイベント記事一覧';
          }

          if (empty($cat_name)) {
            $cat_name .= 'コラボカテゴリー';
          }
        ?>
        <h1 class="archive-title h2">
          <?php if (is_category() || is_tax()) {?>
            <span class="gf"><?php _e( 'CATEGORY', 'moaretrotheme' ); ?></span> <?php single_cat_title(); ?>
          <?php } elseif (is_post_type_archive()) { ?>
            <span class="gf"><?php _e( 'CATEGORY', 'moaretrotheme' ); ?></span> <?php echo $cat_name; ?>
          <?php } ?>
        </h1>
        <?php } elseif (is_tag()) { ?>
        <h1 class="archive-title h2">
          <span class="gf"><?php _e( 'TAG', 'moaretrotheme' ); ?></span> <?php single_tag_title(); ?>
        </h1>
        <?php } elseif (is_author()) {
          global $post;
          $author_id = $post->post_author;
        ?>
        <h1 class="archive-title h2">
          <span class="author-icon"><?php echo get_avatar(get_the_author_id(), 150); ?></span>
          「<?php the_author_meta('display_name', $author_id); ?>」の記事
        </h1>
        <?php } elseif (is_day()) { ?>
          <h1 class="archive-title h2"><?php the_time('Y年n月j日'); ?></h1>
        <?php } elseif (is_month()) { ?>
          <h1 class="archive-title h2"><?php the_time('Y年n月'); ?></h1>
        <?php } elseif (is_year()) { ?>
          <h1 class="archive-title h2"><?php the_time('Y年'); ?></h1>
        <?php } ?>
      </div>

      <?php
        // $event_taxonomy_cat = 'event-category';

        // if (is_tax($event_taxonomy_cat, 'collabo-period')) {
        // }
      ?>
      <?php if (category_description() && !is_paged()) : ?>
        <!-- <div class="taxonomy-description entry-content"><?php echo category_description(); ?></div> -->
      <?php endif; ?>
      <?php
        $toplayout = get_option('opencage_archivelayout');
        $toplayoutsp = get_option('opencage_sp_archivelayout');
      ?>
      <?php if (is_mobile()) :?>
        <?php if ( $toplayoutsp == "toplayout-big" ) : ?>
        <?php get_template_part( 'parts_archive_big' ); ?>
        <?php elseif ( $toplayoutsp == 'toplayout-card' ) : ?>
        <?php get_template_part( 'parts_archive_card' ); ?>
        <?php elseif ( $toplayoutsp == 'toplayout-magazine' ) : ?>
        <?php get_template_part( 'parts_archive_magazine' ); ?>
        <?php else : ?>
        <?php get_template_part( 'parts_archive_simple' ); ?>
        <?php endif;?>
      <?php else : ?>
        <?php if ( $toplayout == "toplayout-big" ) : ?>
        <?php get_template_part( 'parts_archive_big' ); ?>
        <?php elseif ( $toplayout == 'toplayout-card' ) : ?>
        <?php get_template_part( 'parts_archive_card' ); ?>
        <?php elseif ( $toplayout == 'toplayout-magazine' ) : ?>
        <?php get_template_part( 'parts_archive_magazine' ); ?>
        <?php else : ?>
        <?php get_template_part( 'parts_archive_simple' ); ?>
        <?php endif;?>
      <?php endif;?>
    </main>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>
