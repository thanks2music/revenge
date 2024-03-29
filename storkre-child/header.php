<!doctype html>
<?php
  global $is_sp, $is_pc, $amp_flag, $url;
?>

  <html lang="ja">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title(''); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <?php if (is_single()) {
    $post_type = get_post_type();

    if ($post_type === 'event') {
      $not_amp_page_flag = get_post_meta($post->ID, 'not_amp_page', true);

      if (empty($not_amp_page_flag)) { ?>
        <link rel="amphtml" href="<?php echo get_permalink() .'?amp=1'; ?>">
      <?php }
    }
  } ?>

  <link rel="icon" href="<?php echo $url['home']; ?>/wp-content/uploads/favicon_64.png">
  <link rel="apple-touch-icon" href="<?php echo $url['home']; ?>/wp-content/uploads/apple-touch-icon180x180.png">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

  <?php get_template_part('head'); ?>
  <?php if (is_prod()) { ?>
    <?php get_template_part('partials/adx'); ?>
  <?php } ?>
  <?php wp_head(); ?>

  </head>
  <?php
    $body_class = '';
    $event_taxonomy_cat = 'event-category';

    if ($is_sp) {
      $body_class .= 'sp no-amp';
    } else {
      $body_class .= 'pc';
    }

    if (is_android()) {
      $body_class .= ' android';
    }

    if (is_ios()) {
      $body_class .= ' ios';
    }
  ?>
  <body <?php body_class($body_class); ?>>
    <?php get_template_part('partials/meta/gtm'); ?>
    <?php if ($is_sp) {
      get_template_part('partials/ad_geniee');
      get_template_part('partials/app/smart_banner');
    } ?>
    <div id="container" class="<?php echo esc_html(get_option('post_options_ttl'));?> <?php echo esc_html(get_option('side_options_sidebarlayout'));?> <?php echo esc_html(get_option('post_options_date'));?>">
    <?php if ( !is_singular( 'post_lp')): ?>

    <?php if (get_option( 'side_options_description')) : ?>
      <p class="site_description"><?php bloginfo('description'); ?></p>
    <?php endif; ?>

    <header class="header animated fadeIn <?php echo esc_html(get_option('side_options_headerbg'));?> <?php if ( wp_is_mobile() ) : ?>headercenter<?php else:?><?php echo get_option( 'side_options_headercenter' ); ?><?php endif; ?>" role="banner">
      <div id="inner-header" class="wrap cf">
        <div class="header__inner">
          <?php if ($is_sp) {
            get_template_part('partials/global-menu-drawer');
          } ?>

          <div id="logo" class="wf-amatic <?php echo esc_html(get_option('opencage_logo_size'));?>">
            <?php if (is_home() || is_front_page()) : ?>
              <?php if (get_theme_mod( 'opencage_logo')) : ?>
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

          <?php if ($is_pc) { ?>
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

          <?php } elseif (!get_option('side_options_header_search')) { ?>
            <a href="#searchbox" data-remodal-target="searchbox" class="nav_btn search_btn"><span class="text gf">search</span></a>
          <?php } ?>
        </div>
      </div>
    </header>

    <?php if (! get_option('side_options_header_search')) { ?>
      <div class="remodal searchbox" data-remodal-id="searchbox" data-remodal-options="hashTracking:false">
        <div class="search cf"><dl><dt>キーワードで記事を検索</dt><dd><?php get_search_form(); ?></dd></dl></div>
        <button data-remodal-action="close" class="remodal-close"><span class="text gf">CLOSE</span></button>
      </div>
    <?php } ?>

    <?php if (get_option('other_options_headerunderlink') && get_option('other_options_headerundertext')) { ?>
      <div class="header-info <?php echo esc_html(get_option('side_options_headerbg'));?>"><a<?php if(get_option('other_options_headerunderlink_target')):?> target="_blank"<?php endif;?> href="<?php echo esc_html(get_option('other_options_headerunderlink'));?>"><?php echo esc_html(get_option('other_options_headerundertext'));?></a></div>
    <?php } ?>

    <?php get_template_part('parts_homeheader'); ?>

    <?php breadcrumb(); ?>
  <?php endif; ?>
