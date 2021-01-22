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
    <?php if ($is_sp) {
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
          <?php get_template_part('header-globalmenus'); ?>
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
