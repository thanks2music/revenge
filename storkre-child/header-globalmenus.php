<?php
  global $is_sp, $is_pc, $amp_flag;

  if ($is_sp) {
    get_template_part('partials/global-menu-drawer');
  }
?>

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
