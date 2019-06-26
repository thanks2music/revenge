<?php 
  //ナビドロワー（モバイルのみ）
  if(wp_is_mobile() && is_active_sidebar( 'nav_drawer' )):
?>
  <div id="drawer">
    <input type="checkbox" id="drawer__input" class="drawer--unshown" >
    <label id="drawer__open" for="drawer__input"><?php fa_tag("bars","bars",false) ?></label>
    <label class="drawer--unshown" id="drawer__close-cover" for="drawer__input"></label>
    <div id="drawer__content">
      <div class="drawer__title dfont">MENU<label class="close" for="drawer__input"><span></span></label></div>
      <?php dynamic_sidebar('nav_drawer'); ?>
    </div>
  </div>
<?php 
  endif;
  //END ナビドロワー
?>