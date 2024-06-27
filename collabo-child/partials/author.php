<?php
  global $amp_flag;
  // 著者設定
  $author_id = $post->post_author;
  $avatar_icon_url = get_avatar_url($author_id);
  $author_url = get_author_posts_url($author_id);
  $author_posts_count = get_the_author_posts();
  $author_name = get_the_author_meta('display_name', $author_id);
  $author_description = get_the_author_meta('description', $author_id);
  $author_position = get_the_author_meta('position');
  $avatar_icon = '';

  if (! empty($author_description)) { ?>
    <div class="entry__author__overview">
      <figure class="entry__author__image">
        <?php if ($author_id == 1) {
          $avatar_icon .= '<a href="' . $author_url . '">';
        }
          if ($amp_flag) {
            $avatar_icon .= '<amp-img src="' . $avatar_icon_url .'" alt="' . $author_name . '" width="80" height="80" layout="responsive">';
            $avatar_icon .= '</amp-img>';
          } else {
            $avatar_icon .= '<img src="/wp-content/uploads/dummy.png" data-src="' . $avatar_icon_url .'" alt="';
            $avatar_icon .= $author_name . '" class="entry__author__image__icon" />';
          }

          if ($author_id == 1) {
            $avatar_icon .= '</a>';
          }

          echo $avatar_icon;
        ?>
      </figure>
      <div class="entry__author__names">
        <p class="entry__author__names__caption">この記事を書いた人</p>
        <p class="entry__author__names__name">
          <?php if ($author_id == 1) { ?>
            <a href="<?php echo $author_url; ?>"><?php echo $author_name; ?></a>
          <?php } else { ?>
            <?php echo $author_name; ?>
          <?php } ?>
          <span class="entry__author__names__post-count">(全<?php echo $author_posts_count; ?>件)</span>
        </p>
        <p class="entry__author__names__position"><?php echo $author_position; ?></p>
      </div>
    </div>
    <div class="entry__author__description">
      <p class="entry__author__description__p"><?php echo $author_description; ?></p>
    </div>
    <?php
  }

