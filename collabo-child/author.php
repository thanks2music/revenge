<?php global $is_sp, $is_pc; ?>
<?php get_header(); ?>
<div id="content">
  <div id="inner-content" class="wrap cf">
    <main id="main" class="m-all t-all d-5of7 cf" role="main">
      <div class="archivettl">
        <?php
          $archive_title = 'archive__title__author';
          $author_name = get_the_author_meta('display_name', $author);
          // TODO 正しい数を取得出来ていない
          // $author_posts_count = get_the_author_posts();
        ?>
        <h1 class="archive-title h2 <?php echo $archive_title; ?>">
          <span class="archive__title__author-icon"><?php echo get_avatar($author); ?></span>
          <p class="archive__title__author-text">
            <span class="archive__title__author-text__title"><?php echo $author_name; ?>さんが書いた記事一覧</span>
          </p>
        </h1>
      </div>

      <?php get_template_part( 'parts_archive_simple' ); ?>
    </main>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>

