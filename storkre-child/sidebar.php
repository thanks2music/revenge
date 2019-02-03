<div id="sidebar1" class="sidebar m-all t-all d-2of7 cf" role="complementary">

<?php if ( is_mobile()) : ?>
  <?php if ( is_active_sidebar( 'sp-contentfoot' )) : ?>
    <?php dynamic_sidebar( 'sp-contentfoot' ); ?>
  <?php else:?>
    <?php dynamic_sidebar( 'sidebar1' ); ?>
  <?php endif; ?>
<?php else:?>
  <?php dynamic_sidebar( 'sidebar1' ); ?>
<?php endif; ?>

<?php if ( is_active_sidebar( 'side-fixed' ) && !wp_is_mobile() ) : ?>
  <div id="scrollfix" class="add fixed cf">
    <?php dynamic_sidebar( 'side-fixed' ); ?>
  </div>
<?php endif; ?>
</div>
