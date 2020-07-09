<?php
  global $amp_flag, $is_sp, $is_pc;
?>
<div id="page-top">
  <a href="#header" title="ページトップへ"><i class="fa fa-chevron-up"></i></a>
</div>
<?php if(!is_singular( 'post_lp' ) ): ?>
<div id="footer-top" class="wow animated fadeIn cf <?php echo get_option('side_options_headerbg');?>">
  <div class="inner wrap cf">
    <?php if ( is_mobile() && is_active_sidebar( 'footer-sp' )) : ?>
    <?php dynamic_sidebar( 'footer-sp' ); ?>
    <?php else:?>
    <?php if ( is_active_sidebar( 'footer1' ) ) : ?>
      <div class="m-all t-1of2 d-1of3">
      <?php dynamic_sidebar( 'footer1' ); ?>
      </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'footer2' ) ) : ?>
      <div class="m-all t-1of2 d-1of3">
      <?php dynamic_sidebar( 'footer2' ); ?>
      </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'footer3' ) ) : ?>
      <div class="m-all t-1of2 d-1of3">
      <?php dynamic_sidebar( 'footer3' ); ?>
      </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<footer id="footer" class="footer <?php echo get_option('side_options_headerbg');?>" role="contentinfo">
  <div id="inner-footer" class="inner wrap cf">
    <nav role="navigation">
<?php wp_nav_menu(array(
  'container' => 'div',
  'container_class' => 'footer-links cf',
  'menu' => __( 'Footer Links' ),
  'menu_class' => 'footer-nav cf',
  'theme_location' => 'footer-links',
  'before' => '',
  'after' => '',
  'link_before' => '',
  'link_after' => '',
  'depth' => 0,
  'fallback_cb' => ''
)); ?>
    </nav>
    <div class="footer__copyright">
      &copy; <?php echo date('Y'); ?> <?php dynamic_sidebar('common_copyright'); ?>
    </div>
  </div>
</footer>
</div>
<?php  wp_footer(); ?>
</body>
</html>
