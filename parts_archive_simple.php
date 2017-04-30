<div class="top-post-list">
<?php

  $args = array(
    'post_type' => array('post', 'page', 'event'),
    'posts_per_page' => 10,
    'order' => 'DESC',
    'orderby' => 'date modified',
    'post_status' => 'publish',
  );

  // Main Post
  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) {
    while ($the_query->have_posts()) {
      $the_query->the_post();
      $post_type = get_post_type();
      $taxonomy_name = 'category';

      if ($post_type === 'event') {
        $taxonomy_name = 'event-category';
      }

      $cat_name = '';
      $cat = get_the_terms($post->ID, $taxonomy_name);

      for ($i = 0; $i < count($cat); $i++) {
        if ($cat[$i]->slug !== 'cafe') {
          $cat_name .= $cat[$i]->name;
        }
      }
?>

<article <?php post_class('post-list animated fadeIn'); ?> role="article">
  <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="cf">

    <?php if ( has_post_thumbnail()) { ?>
      <figure class="eyecatch">
        <?php the_post_thumbnail('home-thum'); ?>
        <span class="cat-name cat-id-<?php echo $cat[0]->cat_ID;?>"><?php echo $cat_name; ?></span>
      </figure>
    <?php } else { ?>
      <figure class="eyecatch noimg">
        <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
        <span class="cat-name cat-id-<?php echo $cat[0]->cat_ID;?>"><?php echo $cat_name; ?></span>
      </figure>
    <?php } ?>

    <section class="entry-content">
      <h1 class="h2 entry-title"><?php the_title(); ?></h1>

      <p class="byline entry-meta vcard">
        <span class="date gf updated"><?php the_time('Y.m.d'); ?></span>
        <span class="writer name author"><span class="fn"><?php the_author(); ?></span></span>
      </p>

      <?php if (! is_mobile()) { ?>
        <div class="description"><?php the_excerpt(); ?></div>
      <?php } ?>
    </section>
  </a>
</article>

<?php } // end while the_post(); ?>


<?php } elseif (is_search()) { ?>
  <article id="post-not-found" class="hentry cf">
    <header class="article-header">
      <h1>記事が見つかりませんでした。</h1>
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

<?php } else { ?>
  <article id="post-not-found" class="hentry cf">
    <header class="article-header">
      <h1>まだ投稿がありません！</h1>
    </header>
    <section class="entry-content">
      <p>表示する記事がまだありません。</p>
    </section>
  </article>

<?php } // end if have_posts
  wp_reset_postdata();
?>
</div>
