<?php global $amp_flag; ?>
<div class="related-box original-related related">
  <div class="inbox">
    <p class="related-h h_ttl related__title">この記事を読んだ人は、こんな記事も読んでいます。</p>
    <div class="ad__related-post related-post">
      <div class="related__event">
        <?php if (get_the_terms(get_the_ID(), 'event-tag') && ! is_wp_error(get_the_terms(get_the_ID(), 'event-tag'))) {
          $terms = get_the_terms(get_the_ID(), 'event-tag');
          $slug = [];

          foreach($terms as $term) {
            $slug[] = $term->slug;
          }

          $current_date = date('Y-m-d');
          $current_date = strval($current_date);
          $args = array(
            'post_type' => array('post', 'event'),
            'posts_per_page' => 10,
            'order' => 'ASC',
            'meta_key' => '_eventorganiser_schedule_start_start',
            'meta_value' => $current_date,
            'meta_compare' => '>',
            'orderby'    => 'meta_value',
            'tax_query' => array(
              array(
                'taxonomy' => 'event-tag',
                'field' => 'slug',
                'terms' => $slug
              )
            )
          );

          $related_posts = new WP_Query($args);
          if ($related_posts->have_posts()) {
            while ($related_posts->have_posts()) {
              $related_posts->the_post();
              $cf = get_post_custom();
              $endless_flag = get_post_meta($post->ID, 'endless_event_flag', true);
              $title = get_the_title();
              $date_dom = '';
              global $post;

              if (isset($cf['_eventorganiser_schedule_start_start'][0]) && isset($cf['_eventorganiser_schedule_start_finish'][0])) {
                $start_date = $cf['_eventorganiser_schedule_start_start'][0];
                $start_date = date('Y年n月j日', strtotime($start_date));

                if ($endless_flag) {
                  $date_dom .= $start_date . '〜';
                } else {
                  $end_date = $cf['_eventorganiser_schedule_start_finish'][0];
                  $end_date = date('n月j日', strtotime($end_date));
                  $date_dom .= $start_date . '〜' . $end_date;
                }
              }
            ?>
            <div class="related__event__post">
              <figure class="related__event__post__thumbnail">
                <?php
                  if ($amp_flag) {
                    $amp_img = '';
                    $image_array = get_the_thumbnail_image_array($post->ID);
                    $amp_img .= '<amp-img src="'.$image_array[0].'" layout="responsive" width="'.$image_array[1].'" height="'.$image_array[2].'" alt="'.$title.'"></amp-img>';

                    echo $amp_img;
                  } else {
                    the_post_thumbnail('home-thum', array('class' => 'lazy'));
                  }
                ?>
              </figure>
              <p class="related__event__post__title">
                <?php echo $title; ?>
                <?php if (! empty($date_dom)) { ?>
                  <span class="related__event__post__date"><?php echo $date_dom; ?></span>
                <?php } ?>
              </p>
            </div>
            <?php }
          }
        } ?>
      </div>
      <div class="ad__related-post--google">
        <?php if (! $amp_flag) { ?>
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <ins class="adsbygoogle"
               style="display:block"
               data-ad-format="autorelaxed"
               data-ad-client="ca-pub-7307810455044245"
               data-ad-slot="7735657787"></ins>
          <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        <?php } else { ?>
          <amp-ad
            layout="fixed-height"
            height=600
            type="adsense"
            data-ad-client="ca-pub-7307810455044245"
            data-ad-slot="7735657787">
          </amp-ad>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
