<?php // 著者設定
  $author_id = $post->post_author;
  $avatar_icon = get_avatar($author_id);
  $author_url = get_author_posts_url($author_id);
  $author_posts_count = get_the_author_posts();
  $author_name = get_the_author_meta('display_name', $author_id);
  $author_description = get_the_author_meta('description', $author_id);
  $author_position = get_the_author_meta('position');

  if (! empty($author_description)) { ?>
    <div class="entry__author__overview">
      <figure class="entry__author__image">
        <a href="<?php echo $author_url; ?>">
          <?php echo $avatar_icon; ?>
        </a>
      </figure>
      <div class="entry__author__names">
        <p class="entry__author__names__name">
          <a href="<?php echo $author_url; ?>"><?php echo $author_name; ?></a>
          <?php /* <span class="entry__author__names__post-count">(記事投稿数: <?php echo $author_posts_count; ?>)</span> */ ?>
        </p>
        <p class="entry__author__names__position"><?php echo $author_position; ?></p>
      </div>
    </div>
    <div class="entry__author__description">
      <p class="entry__author__description__p"><?php echo $author_description; ?></p>
    </div>
    <?php
  }

