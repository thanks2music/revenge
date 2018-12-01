<!doctype html>
<?php
  global $is_sp, $is_pc, $amp_flag;
?>

  <html lang="ja">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title(''); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <?php if (is_single()) { ?>
    <link rel="amphtml" href="<?php echo get_permalink() .'?amp=1'; ?>">
  <?php } ?>

  <?php if ( get_theme_mod( 'opencage_appleicon' ) ) : ?><link rel="apple-touch-icon" href="<?php echo get_theme_mod( 'opencage_appleicon' ); ?>"><?php endif; ?>
  <?php if ( get_theme_mod( 'opencage_favicon' ) ) : ?><link rel="icon" href="<?php echo get_theme_mod( 'opencage_favicon' ); ?>"><?php endif; ?>

  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

  <!--[if IE]>
  <?php if ( get_theme_mod( 'opencage_favicon_ie' ) ) : ?><link rel="shortcut icon" href="<?php echo get_theme_mod( 'opencage_favicon_ie' ); ?>"><?php endif; ?>
  <![endif]-->
  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->

  <?php get_template_part( 'head' ); ?>

  <?php wp_head(); ?>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script>
    (adsbygoogle = window.adsbygoogle || []).push({
      google_ad_client: "ca-pub-7307810455044245",
      enable_page_level_ads: true
    });
  </script>
  <script src="//j.wovn.io/1" data-wovnio="key=ERGLmO" async></script>
  </head>
  <?php
    $body_class = '';
    $event_taxonomy_cat = 'event-category';
    if ($is_sp) {
      $body_class .= 'sp no-amp';
    } else {
      $body_class .= 'pc';
    }

    if (is_tax($event_taxonomy_cat, 'collabo-period')) {
      $terms = get_the_terms($post->ID, $event_taxonomy_cat);
      $term_len = count($terms);

      for($i = 0; $i < $term_len; $i++) {
        if (! empty($terms[$i]->description)) {
          $des = $terms[$i]->description;
        }

        // 親カテゴリがあったら
        // for 期間別一覧の子カテゴリ
        if ($terms[$i]->parent !== 0) {
          // 親の情報を取得
          $term_parent_id = $terms[$i]->parent;
          $term_parent = get_term($term_parent_id, $event_taxonomy_cat);
          $parent_des = $term_parent->description;

          // 親カテゴリの紹介文があるか
          if (isset($parent_des) && $parent_des === 'common') {
            $body_class .= ' period child-period';
          }
        }

        // 期間別一覧の場合
        // 紹介文で分岐
        if (isset($des) && $des === 'common') {
          $body_class .= ' period';
        }
      }
    }
  ?>
  <body <?php body_class($body_class); ?>>
  <?php get_template_part('partials/meta/gtm'); ?>
  <div id="container" class="<?php echo esc_html(get_option('post_options_ttl'));?> <?php echo esc_html(get_option('side_options_sidebarlayout'));?> <?php echo esc_html(get_option('post_options_date'));?>">
  <?php if(!is_singular( 'post_lp' ) ): ?>

  <?php if ( get_option( 'side_options_description' ) ) : ?><p class="site_description"><?php bloginfo('description'); ?></p><?php endif; ?>
  <header class="header animated fadeIn <?php echo esc_html(get_option('side_options_headerbg'));?> <?php if ( wp_is_mobile() ) : ?>headercenter<?php else:?><?php echo get_option( 'side_options_headercenter' ); ?><?php endif; ?>" role="banner">
  <div id="inner-header" class="wrap cf">
  <div id="logo" class="wf-amatic <?php echo esc_html(get_option('opencage_logo_size'));?>">
  <?php if ( is_home() || is_front_page() ) : ?>
  <?php if ( get_theme_mod( 'opencage_logo' ) ) : ?>
  <h1 class="h1 img"><a href="<?php echo home_url(); ?>" rel="nofollow"><img src="<?php echo get_theme_mod( 'opencage_logo' ); ?>" alt="<?php bloginfo('name'); ?>"></a></h1>
  <?php else : ?>
  <h1 class="h1 text"><a href="<?php echo home_url(); ?>" rel="nofollow">Collabo Cafe</a></h1>
  <?php endif; ?>
  <?php else: ?>
  <?php if ( get_theme_mod( 'opencage_logo' ) ) : ?>
  <p class="h1 img"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_theme_mod( 'opencage_logo' ); ?>" alt="<?php bloginfo('name'); ?>"></a></p>
  <?php else : ?>
  <p class="h1 text"><a href="<?php echo home_url(); ?>">Collabo Cafe</a></p>
  <?php endif; ?>
  <?php endif; ?>
  </div>

  <?php if (!is_mobile()):?>
  <nav id="g_nav" role="navigation">
  <?php if(!get_option('side_options_header_search')):?>
  <a href="#searchbox" data-remodal-target="searchbox" class="nav_btn search_btn"><span class="text gf">search</span></a>
  <?php endif;?>

  <?php wp_nav_menu(array(
       'container' => false,
       'container_class' => 'menu cf',
       'menu' => __( 'グローバルナビ' ),
       'menu_class' => 'nav top-nav cf',
       'theme_location' => 'main-nav',
       'before' => '',
       'after' => '',
       'link_before' => '',
       'link_after' => '',
       'depth' => 0,
       'fallback_cb' => ''
  )); ?>
  </nav>
  <?php elseif(!get_option('side_options_header_search')):?>
  <a href="#searchbox" data-remodal-target="searchbox" class="nav_btn search_btn"><span class="text gf">search</span></a>
  <?php endif;?>

  <a href="#spnavi" data-remodal-target="spnavi" class="nav_btn"><span class="text gf">menu</span></a>


  </div>
  </header>

  <?php if (is_active_sidebar('sidebar-sp')):?>
  <div class="remodal" data-remodal-id="spnavi" data-remodal-options="hashTracking:false">
  <button data-remodal-action="close" class="remodal-close"><span class="text gf">CLOSE</span></button>
  <?php if ($amp_flag) {
    } else {
      dynamic_sidebar( 'sidebar-sp' );
    }
    ?>
  <button data-remodal-action="close" class="remodal-close"><span class="text gf">CLOSE</span></button>
  </div>

  <?php else:?>

  <div class="remodal" data-remodal-id="spnavi" data-remodal-options="hashTracking:false">
  <button data-remodal-action="close" class="remodal-close"><span class="text gf">CLOSE</span></button>
  <?php wp_nav_menu(array(
       'container' => false,
       'container_class' => 'sp_g_nav menu cf',
       'menu' => __( 'グローバルナビ' ),
       'menu_class' => 'sp_g_nav nav top-nav cf',
       'theme_location' => 'main-nav',
       'before' => '',
       'after' => '',
       'link_before' => '',
       'link_after' => '',
       'depth' => 0,
       'fallback_cb' => ''
  )); ?>
  <button data-remodal-action="close" class="remodal-close"><span class="text gf">CLOSE</span></button>
  </div>

  <?php endif; ?>


  <?php if(!get_option('side_options_header_search')):?>
  <div class="remodal searchbox" data-remodal-id="searchbox" data-remodal-options="hashTracking:false">
  <div class="search cf"><dl><dt>キーワードで記事を検索</dt><dd><?php get_search_form(); ?></dd></dl></div>
  <button data-remodal-action="close" class="remodal-close"><span class="text gf">CLOSE</span></button>
  </div>
  <?php endif;?>



  <?php if(is_mobile()):?>
  <div class="g_nav-sp animated fadeIn">
  <?php wp_nav_menu(array(
       'container' => 'nav',
       'container_class' => 'menu-sp cf',
       'menu' => __( 'グローバルナビ（スマートフォン）' ),
       'menu_class' => 'top-nav',
       'theme_location' => 'main-nav-sp',
       'before' => '',
       'after' => '',
       'link_before' => '',
       'link_after' => '',
       'depth' => 0,
       'fallback_cb' => ''
  )); ?>
  </div>
  <?php endif;?>

  <?php if ( get_option('other_options_headerunderlink') && get_option('other_options_headerundertext') ) : ?>
  <div class="header-info <?php echo esc_html(get_option('side_options_headerbg'));?>"><a<?php if(get_option('other_options_headerunderlink_target')):?> target="_blank"<?php endif;?> href="<?php echo esc_html(get_option('other_options_headerunderlink'));?>"><?php echo esc_html(get_option('other_options_headerundertext'));?></a></div>
  <?php endif;?>

  <?php get_template_part( 'parts_homeheader' ); ?>

  <?php breadcrumb(); ?>
  <?php endif; ?>
