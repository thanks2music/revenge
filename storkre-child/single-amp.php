<?php global $is_sp, $is_pc, $amp_flag, $dir, $url;

if ($amp_flag) {
  $file_path = $dir['theme'] . '/dist/css/amp.css';
  $file_path = mb_substr($file_path, 25);
  $amp_style_path = ABSPATH . $file_path;
  $amp_style = file_get_contents($amp_style_path);
  $image_id = get_post_thumbnail_id();
  $image_url = wp_get_attachment_image_src($image_id, true);
  $canonical_url = get_permalink();
  $author_id = "1";

  if (isset($post)) {
    $author_id = $post->post_author;
  } ?>
<!doctype html>
<html ⚡>
  <head>
    <meta charset="utf-8">
    <title><?php wp_title(''); ?></title>
    <link rel="canonical" href="<?php echo $canonical_url; ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <style amp-custom>
      <?php echo $amp_style; ?>
    </style>
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "NewsArticle",
      "headline": "<?php the_title(); ?>",
      "image": [
        "<?php echo $image_url[0]; ?>"
      ],
      "datePublished": "<?php the_time('Y/m/d') ?>",
      "dateModified": "<?php the_modified_date('Y/m/d') ?>",
      "author": {
        "@type": "Person",
        "name": "<?php the_author_meta('nickname', $author_id); ?>"
      },
      "publisher": {
        "@type": "Organization",
        "name": "<?php bloginfo('name'); ?>",
        "logo": {
          "@type": "ImageObject",
            "url": "<?php echo $url['home']; ?>/wp-content/uploads/logo_og.png",
          "width": 750,
          "height": 394,
            /* NOTE: 記事ogなら以下
              "url": "<?php echo $image_url[0]; ?>",
              "width": <?php echo $image_url[1]; ?>,
              "height": <?php echo $image_url[2]; ?>,
             */
        }
      },
      "description": "<?php echo mb_substr(strip_tags($post->post_content), 0, 60); ?>",
    }
    </script>
    <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
    <script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>
    <script async custom-element="amp-image-lightbox" src="https://cdn.ampproject.org/v0/amp-image-lightbox-0.1.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Concert+One|Lato" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <link rel="amphtml" href="<?php echo $canonical_url . '?amp=1'; ?>">
  </head>
  <?php
    $body_class = 'sp amp';
  ?>
  <body <?php body_class($body_class); ?>>
    <?php get_template_part('partials/meta/gtm'); ?>
    <main class="amp__container" id="single__container">
      <header class="amp__header">
        <?php if (get_option('side_options_description')) { ?>
          <p class="amp__site-description"><?php bloginfo('description'); ?></p>
        <?php } ?>

        <div class="drawer">
          <input type="checkbox" class="drawer__form--hidden" id="drawer__input">
          <label class="drawer__open" for="drawer__input">
            <i class="fa fa-bars"></i>
          </label>
          <label class="drawer__close-cover" for="drawer__input"></label>
          <div class="drawer__content">
            <div class="drawer__title dfont">
              MENU
              <label class="drawer__content__close" for="drawer__input"><span></span></label>
            </div>

            <div class="drawer__content__nav">
              <?php dynamic_sidebar('widget_nav_drawer'); ?>
            </div>
          </div>
        </div>
        <h1 class="amp__logo"><a href="/" rel="nofollow"><?php bloginfo('site_name'); ?></a></h1>
      </header>
      <div class="amp__breadcrumb">
        <?php breadcrumb(); ?>
      </div>
      <div class="amp__content">
        <div class="amp__content__inner cf">
        <?php while(have_posts()) {
          the_post();
          $post_class = 'amp__entry';
        ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?> role="article">
            <?php dynamic_sidebar('addbanner-titletop'); // 記事上部のアドセンス ?>
            <header class="article-header entry-header amp__entry__header">
              <?php // 記事更新時間 ?>
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

              <h1 class="entry-title single-title amp__entry__title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

              <?php if (has_post_thumbnail() && !get_option('post_options_eyecatch')) { ?>
                <figure class="eyecatch amp__eyecatch">
                  <?php
                    $amp_img = '';
                    $image_array = get_the_thumbnail_image_array($post->ID);
                    $title = get_the_title();
                    $amp_img .= '<amp-img src="'.$image_array[0].'" layout="responsive" width="'.$image_array[1].'" height="'.$image_array[2].'" alt="'.$title.'"></amp-img>';

                    echo $amp_img;
                  ?>
                </figure>
              <?php } ?>
              <?php // NOTE: header閉じる前に get_template_part( 'parts_sns_short' ); でSNS類呼び出しているが、onclick=""など指定しているっぽいので一旦呼び出さないでおく ?>
            </header>

            <div class="amp__ad--eyecatch-under">
              <amp-ad
                 layout="responsive"
                 width=300
                 height=250
                 type="adsense"
                 data-ad-client="ca-pub-7307810455044245"
                 data-ad-slot="2805411615">
              </amp-ad>
            </div>

            <section class="entry-content cf amp__entry__content">
              <?php
                // フィルターを通してthe_contentを呼び出す
                $the_content = apply_filters('the_content', get_the_content());
                echo $the_content;
              ?>
              <amp-image-lightbox id="lightbox2" layout="nodisplay"></amp-image-lightbox>
              <p class="entry-author vcard author sr-only">
                <span class="writer name fn"><?php the_author_meta('nickname'); ?></span>
              </p>
              <div class="amp__entry__detail">
                <?php get_template_part( 'event-meta-event-single' ); ?>
              </div>
            </section>
            <div class="amp__ad--content-under">
              <amp-ad
                 layout="responsive"
                 width=300
                 height=250
                 type="adsense"
                 data-ad-client="ca-pub-7307810455044245"
                 data-ad-slot="4944211218">
              </amp-ad>
            </div>
          </article>
          <div class="amp__entry__bottom">
          </div>
          <?php get_template_part( 'parts_singlefoot' ); ?>
          <?php } ?>
        </div>
      </div>
      <?php // footerのスタイリング ?>
      <footer id="footer" class="footer" role="contentinfo">
        <div id="inner-footer" class="footer__inner">
          <div class="footer__widgets">
            <?php dynamic_sidebar('amp_footer_content'); ?>
          </div>
          <p class="source-org copyright">&copy;Copyright<?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo( 'name' ); ?></a>.All Rights Reserved.</p>
        </div>
      </footer>
    </main>
  </body>
</html>
<?php
}
