<?php get_header(); ?>
<?php
while (have_posts()) {
  the_post(); ?>

  <div id="single__container" class="single__container">
    <div id="content">
      <div id="inner-content" class="wrap cf">
        <main id="main" class="m-all t-all d-5of7 cf" role="main">
          <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?> role="article">
            <header class="article-header entry-header">
              <p class="byline entry-meta cf">
                <?php
                  $time_class_publish = 'date gf entry-date published';
                  $datetime = 'datetime="';
                  // 編集時間のが大きかったら
                  if (get_the_date('Ymd') < get_the_modified_date('Ymd')) {
                    // 編集していなかったら
                  } else {
                    $time_class_publish .= ' updated';
                  }

                  if (get_the_date('Ymd') >= get_the_modified_date('Ymd')) {
                    $datetime .= get_the_date('Y-m-d') . '"';
                  } else {
                    $datetime = '';
                  }
                ?>
                <time class="<?php echo $time_class_publish; ?>" <?php echo $datetime; ?>><?php echo get_the_date('Y.m.d'); ?></time>
                <?php if (get_the_date('Ymd') < get_the_modified_date('Ymd')) { ?>
                  <time class="date gf entry-date undo updated sr-only" datetime="<?php echo get_the_modified_date( 'Y-m-d' ) ?>"><?php echo get_the_modified_date('Y.m.d') ?></time>
                <?php } ?>
              </p>

              <h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

              <?php if (has_post_thumbnail() && ! get_option('post_options_eyecatch')) { ?>
                <figure class="eyecatch">
                <?php // NOTE: 引数にclassを指定し、「lazy」classをつけると遅延読み込みの対象にする。アイキャッチ画像は最初に表示させたいので遅延ロード行わない ?>
                <?php the_post_thumbnail('full', array('class' => 'size-full wp-image wp-eyecatch')); ?>
                </figure>
              <?php } ?>
            </header>

            <?php if (is_active_sidebar('addbanner-sp-titleunder')) { ?>
              <?php if (wp_is_mobile()) { ?>
                <div class="ad__title-under">
                  <?php dynamic_sidebar('addbanner-sp-titleunder'); ?>
                </div>
              <?php } ?>
            <?php } ?>

            <section class="entry-content cf">
              <?php if (is_active_sidebar('addbanner-pc-titleunder') && ! wp_is_mobile()) { ?>
                <div class="ad__title-under">
                  <?php dynamic_sidebar('addbanner-pc-titleunder'); ?>
                </div>
              <?php } ?>

              <?php
                // フィルターを通してthe_contentを呼び出す
                $the_content = apply_filters('the_content', get_the_content());
                echo $the_content;

                page_nav_singular();
              ?>

              <div class="entry__author">
                <?php get_template_part('partials/author'); ?>
              </div>

              <div class="entry__detail">
                <?php get_template_part('event-meta-event-single'); ?>
              </div>

              <?php if (is_active_sidebar('addbanner-pc-contentfoot') && ! is_mobile()) { ?>
                <div class="ad__pc-content">
                  <?php dynamic_sidebar('addbanner-pc-contentfoot'); ?>
                </div>
              <?php } ?>
              <p class="entry-author vcard author">
                <span class="writer name fn"><?php the_author_meta('nickname'); ?></span>
              </p>
            </section>

            <?php if ( is_active_sidebar( 'addbanner-sp-contentfoot' ) && is_mobile() ) { ?>
            <div class="ad__sp-content">
              <?php dynamic_sidebar( 'addbanner-sp-contentfoot' ); ?>
            </div>
            <?php } ?>

            <?php // Google Recommend ?>
            <?php if ($is_sp) { ?>
              <div class="ad__google-recommend--sp">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-format="autorelaxed"
                     data-ad-client="ca-pub-7307810455044245"
                     data-ad-slot="7735657787"></ins>
                <script>
                   (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
              </div>

              <hr class="hr__gradient">

              <div class="ad__taxel__gmo-recommend">
                <div id="gmo_rw_12370" data-gmoad="rw"></div>
              </div>
            <?php } ?>

            <?php if (get_option('fbbox_options_url')) { ?>
              <?php $fburl = get_option('fbbox_options_url');?>
              <div class="fb-likebtn wow animated fadeIn cf">
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.4";
                fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>

                <figure class="eyecatch">
                  <?php if (has_post_thumbnail()) { ?>
                <?php the_post_thumbnail('home-thum', array('class' => 'lazy attachment-home-thum size-home-thum wp-post-image')); ?>
                <?php } else { ?>
                  <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
                <?php } ?>
                </figure>

                <div class="rightbox">
                  <div class="fb-like fb-button" data-href="<?php echo $fburl;?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                  <div class="like_text">
                    <p>この記事が気に入ったら<br><i class="fa fa-thumbs-up"></i> いいねしよう！</p>

                    <?php if(! is_mobile()) { ?>
                      <p class="small">最新記事をお届けします。</p>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php } ?>

          </article>
          <?php get_template_part('parts_singlefoot'); ?>
        </main>
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>
<?php wp_reset_query(); //ワンカラム条件分岐END ?>
<?php } ?>
<?php get_footer(); ?>
