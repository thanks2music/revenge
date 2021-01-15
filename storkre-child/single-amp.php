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
    <meta name="amp-google-client-id-api" content="googleanalytics">
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
    <link rel="amphtml" href="<?php echo $canonical_url . '?amp=1'; ?>">
    <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
    <script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
    <script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
    <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
    <script async custom-element="amp-image-lightbox" src="https://cdn.ampproject.org/v0/amp-image-lightbox-0.1.js"></script>
    <script async custom-element="amp-lightbox-gallery" src="https://cdn.ampproject.org/v0/amp-lightbox-gallery-0.1.js"></script>
    <script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>
    <script async custom-element="amp-sticky-ad" src="https://cdn.ampproject.org/v0/amp-sticky-ad-1.0.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Concert+One|Lato" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="icon" href="<?php echo $url['home']; ?>/wp-content/uploads/favicon_64.png">
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
  </head>
  <?php
    $body_class = 'sp amp';
  ?>
  <body <?php body_class($body_class); ?>>
    <?php get_template_part('partials/meta/gtm'); ?>
    <?php get_template_part('partials/app/smart_banner'); ?>
    <main class="amp__container" id="single__container">
      <header class="amp__header">
        <?php if (get_option('side_options_description')) { ?>
          <p class="amp__site-description"><?php bloginfo('description'); ?></p>
        <?php } ?>

        <?php get_template_part('partials/global-menu-drawer'); ?>
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
            <amp-sticky-ad layout="nodisplay">
              <amp-ad width="320"
                  height="100"
                  type="gmossp"
                  data-id="g908890">
              </amp-ad>
            </amp-sticky-ad>
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

            <?php // 記事上部のアドセンス ?>
            <div class="amp__ad--eyecatch-under">
              <?php /* Adsense バージョン */ ?>
              <amp-ad layout="responsive"
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
                page_nav_singular();
              ?>
              <amp-image-lightbox id="lightbox2" layout="nodisplay"></amp-image-lightbox>

              <div class="entry__author">
                <?php get_template_part('partials/author'); ?>
              </div>

              <div class="amp__entry__detail">
                <?php get_template_part( 'event-meta-event-single' ); ?>
              </div>
            </section>
            <div class="amp__ad--content-under">
              <amp-ad width="100vw" height=320
                   type="adsense"
                   data-ad-client="ca-pub-7307810455044245"
                   data-ad-slot="9938351076"
                   data-auto-format="rspv"
                   data-full-width>
                <div overflow></div>
              </amp-ad>
            </div>
            <hr class="hr__gradient">

            <div class="amp__ad--eyecatch-under"><?php echo do_shortcode('[add_app_banner]'); ?></div>
          </article>
          <div class="amp__entry__bottom">
            <div class="amp__ad__taxel__gmo-recommend">
              <amp-iframe width=300 height=300
                sandbox="allow-scripts allow-same-origin allow-top-navigation allow-popups"
                layout="responsive"
                resizable
                frameborder="0"
                src='https://taxel.jp/amp/sponsor.html#{"media": 703, "widget": 12376, "protocol": "https"}'>
                <div overflow="" tabindex="0" role="button" id="taxel-readmore" aria-label="Read more">続きを読む</div>
              </amp-iframe>
            </div>
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
          <div class="footer__copyright">
            &copy; <?php echo date('Y'); ?> <?php dynamic_sidebar('common_copyright'); ?>
          </div>
        </div>
      </footer>
    </main>
  </body>
</html>
<?php
}
