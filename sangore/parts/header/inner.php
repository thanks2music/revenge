<div id="inner-header" class="wrap cf">
  <?php 
    //トップページのみタイトルをh1に
    $title_tag = (is_home() || is_front_page()) ? 'h1' : 'p';
  ?>
  <<?php echo $title_tag; ?> id="logo" class="h1 dfont">
    <a href="<?php echo home_url(); ?>">
      <?php if(get_option('logo_image_upload')) : ?>
        <img src="<?php echo esc_url(get_option('logo_image_upload')); ?>" alt="<?php bloginfo('name'); ?>">
      <?php endif; ?>
      <?php if(!get_option('onlylogo_checkbox')) bloginfo('name'); ?>
    </a>
  </<?php echo $title_tag; ?>>
  <?php 
    //header検索
    get_template_part('parts/header/search');
  ?>
  <?php
    //PC用ヘッダーナビ
    if(has_nav_menu('desktop-nav')) {
      echo '<nav class="desktop-nav clearfix">';
      wp_nav_menu(array(
        'container' => false,
        'theme_location' => 'desktop-nav',
        'depth' => 2,
        'fallback_cb' => ''
      ));
      echo '</nav>';
    }
    //END PC用ヘッダーナビ
  ?>
</div>
<?php
  //モバイル用ヘッダーナビ
  if(wp_is_mobile() && has_nav_menu('mobile-nav')) {
    echo '<nav class="mobile-nav">';
    wp_nav_menu(array(
      'container' => false,
      'theme_location' => 'mobile-nav',
      'depth' => 1,
      'fallback_cb' => ''
    ));
    echo '</nav>';
  }
  //END モバイル用ナビ
?>