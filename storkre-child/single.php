<?php global $amp_flag;
  if ($amp_flag) {
    get_template_part('single-amp');
  } else { ?>
    <?php get_header(); ?>
    <?php
      global $wp_query;
      $postid = $wp_query->post->ID;
      $tai = get_post_meta($postid, 'singlepostlayout_radio', true);
    ?>
    <?php if ($tai == 'フルサイズ（1カラム）' || $tai == 'バイラル風（1カラム）') : ?>
    <?php get_template_part( 'singleparts_full' ); ?>
    <?php else : ?>

    <div id="content">
    <div id="inner-content" class="wrap cf">

    <main id="main" class="m-all t-all d-5of7 cf" role="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php
      $post_class = '';
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?> role="article">
    <?php dynamic_sidebar( 'addbanner-titletop' ); ?>
    <header class="article-header entry-header">
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

    <h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

    <?php if ( has_post_thumbnail() && !get_option( 'post_options_eyecatch' ) ) :?>
    <figure class="eyecatch">
    <?php // NOTE: 引数にclassを指定し、「lazy」classをつけると遅延読み込みの対象にする。アイキャッチ画像は最初に表示させたいので遅延ロード行わない ?>
    <?php the_post_thumbnail('full', array('class' => 'size-full wp-image wp-eyecatch')); ?>
    </figure>
    <?php endif; ?>
    <?php if ( !get_option( 'sns_options_hide' ) ) : ?>
    <?php get_template_part( 'parts_sns_short' ); ?>
    <?php endif; ?>
    </header>


    <?php if ( is_active_sidebar( 'addbanner-sp-titleunder' ) ) : ?>
      <?php if ( wp_is_mobile() ) : ?>
        <div class="add titleunder">
          <?php dynamic_sidebar( 'addbanner-sp-titleunder' ); ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <section class="entry-content cf">

    <?php if (is_active_sidebar('addbanner-pc-titleunder') && !wp_is_mobile()) { ?>
      <div class="add titleunder">
        <?php dynamic_sidebar( 'addbanner-pc-titleunder' ); ?>
      </div>
    <?php } ?>

    <?php
    // フィルターを通してthe_contentを呼び出す
    $the_content = apply_filters('the_content', get_the_content());
    echo $the_content;

    wp_link_pages( array(
    'before'      => '<div class="page-links cf"><ul>',
    'after'       => '</ul></div>',
    'link_before' => '<li><span>',
    'link_after'  => '</span></li>',
    'next_or_number'   => 'next',
    'nextpagelink'     => __('次のページへ ≫'),
    'previouspagelink' => __('≪ 前のページへ'),
    ) );    
    ?>

    <?php if ( is_active_sidebar( 'addbanner-pc-contentfoot' ) && !is_mobile() ) : ?>
    <div class="add">
    <?php dynamic_sidebar( 'addbanner-pc-contentfoot' ); ?>
    </div>
    <?php endif; ?>
      <p class="entry-author vcard author">
        <span class="writer name fn"><?php the_author_meta('nickname'); ?></span>
      </p>
    </section>

    <?php if ( is_active_sidebar( 'addbanner-sp-contentfoot' ) && is_mobile() ) : ?>
    <div class="add">
    <?php dynamic_sidebar( 'addbanner-sp-contentfoot' ); ?>
    </div>
    <?php endif; ?>

    <?php if(is_singular(array('post'))):?>
    <?php // NOTE: get_the_category_listがカスタム投稿に対応していない ?>
    <footer class="article-footer">
    <?php echo get_the_category_list(); ?>
    <?php the_tags( '<p class="tags">', '', '</p>' ); ?>
    </footer>
    <?php endif; ?>


    <?php if (get_option('fbbox_options_url')) : ?>
      <div class="fb-likebtn wow animated fadeIn cf" data-wow-delay="0.5s">
      <?php $fburl = get_option( 'fbbox_options_url' );?>
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.4";
      fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
      <figure class="eyecatch">
      <?php if ( has_post_thumbnail() ): ?>
      <?php the_post_thumbnail('home-thum', array('class' => 'lazy attachment-home-thum size-home-thum wp-post-image')); ?>
      <?php else: ?>
      <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
      <?php endif; ?>
      </figure>
      <div class="rightbox"><div class="fb-like fb-button" data-href="<?php echo $fburl;?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div><div class="like_text"><p>この記事が気に入ったら<br><i class="fa fa-thumbs-up"></i> いいねしよう！</p>
      <?php if( !is_mobile() ): ?><p class="small">最新記事をお届けします。</p><?php endif; ?></div></div></div>
    <?php endif; ?>


    <?php if ( !get_option( 'sns_options_hide' ) ) : ?>
    <div class="sharewrap wow animated fadeIn" data-wow-delay="0.5s">
    <?php if ( get_option( 'sns_options_text' ) ) : ?>
    <h3><?php echo get_option( 'sns_options_text' ); ?></h3>
    <?php endif; ?>
    <?php get_template_part( 'parts_sns' ); ?>
    </div>
    <?php endif; ?>


    <?php if ( is_active_sidebar( 'cta' ) ) : ?>
    <div class="cta-wrap wow animated fadeIn" data-wow-delay="0.7s">
    <?php dynamic_sidebar( 'cta' ); ?>
    </div>
    <?php endif; ?>

    <?php comments_template(); ?>

    </article>

    <?php get_template_part( 'parts_singlefoot' ); ?>

    <?php endwhile; ?>
    <?php endif; ?>
    </main>
    <?php get_sidebar(); ?>
    </div>
    </div>
    <?php endif; wp_reset_query(); //ワンカラム条件分岐END ?>
    <?php get_footer(); ?>
  <?php }
?>
