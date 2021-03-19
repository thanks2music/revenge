<?php global $is_sp, $is_pc; ?>
<?php get_header(); ?>
<?php
  $term_slug = get_slug_by_path();
  $term_content = get_term_by('slug', $term_slug, $taxonomy);
?>
<div id="content" class="event__term__archive">
  <?php
    if (is_tax('event-category') && $is_sp) {
      $work_term = $term_content;

      if (! is_wp_error($work_term) && strpos($work_term->description, 'work__detail') !== false) {
        echo $work_term->description;
      }
    }
  ?>

  <div id="inner-content" class="wrap cf">
    <main id="main" class="m-all t-all d-5of7 cf" role="main">
      <div class="archivettl">
        <?php if (is_archive() || is_post_type_archive()) { ?>
        <?php
          $post_type = get_post_type();
          $taxonomy_name = 'category';
          $cat_name = '';
          $archive_title = '';

          if ($post_type === 'event') {
            $archive_title = 'archive__title__event-post';
            if (is_tax('event-category')) {
              $archive_title = 'archive__title__event-category';
              $taxonomy_name = 'event-category';
            } elseif (is_tax('event-tag')) {
              $archive_title = 'archive__title__event-tag';
              $taxonomy_name = 'event-tag';
            }

            $cat_name .= 'コラボイベント記事一覧';
          }

          if (empty($cat_name)) {
            $cat_name .= 'コラボカテゴリー';
          }
        ?>
        <h1 class="archive-title h2 <?php echo $archive_title; ?>">
          <?php if (is_category() || is_tax()) { ?>
            <?php single_cat_title();
              if (is_tax('event-venue')) {
                echo 'の店舗の開催一覧';
              }
            ?>
          <?php } elseif (is_post_type_archive()) { ?>
            <span class="gf"><?php _e( 'CATEGORY', 'moaretrotheme' ); ?></span> <?php echo $cat_name; ?>
          <?php } ?>
        </h1>
        <?php } elseif (is_tag()) { ?>
        <h1 class="archive-title h2">
          <span class="gf"><?php _e( 'TAG', 'moaretrotheme' ); ?></span> <?php single_tag_title(); ?>
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
        if (is_tax('event-tag')) {
          $shop_term = $term_content;

          if (! is_wp_error($shop_term) && strpos($shop_term->description, 'shop__detail') !== false) {
            echo $shop_term->description;
          }
        }
      ?>

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
