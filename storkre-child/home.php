<?php get_header(); ?>
<div id="content">
<div id="inner-content" class="wrap cf">

<main id="main" class="m-all t-all d-5of7 cf" role="main">
<?php
	$toplayout = get_option('opencage_toppage_archivelayout');
	$toplayoutsp = get_option('opencage_toppage_sp_archivelayout');
?>
<?php if (is_mobile()) :?>
	<?php if ( $toplayoutsp == "toplayout-big" ) : ?>
	<?php get_template_part( 'parts_archive_big' ); ?>
	<?php elseif ( $toplayoutsp == 'toplayout-card' ) : ?>
	<?php get_template_part( 'parts_archive_card' ); ?>
	<?php elseif ( $toplayoutsp == 'toplayout-magazine' ) : ?>
	<?php get_template_part( 'parts_archive_magazine' ); ?>
	<?php else : ?>
	<?php get_template_part( 'parts_archive_simple' ); ?>
	<?php endif;?>
<?php else : ?>
	<?php if ( $toplayout == "toplayout-big" ) : ?>
	<?php get_template_part( 'parts_archive_big' ); ?>
	<?php elseif ( $toplayout == 'toplayout-card' ) : ?>
	<?php get_template_part( 'parts_archive_card' ); ?>
	<?php elseif ( $toplayout == 'toplayout-magazine' ) : ?>
	<?php get_template_part( 'parts_archive_magazine' ); ?>
	<?php else : ?>
	<?php get_template_part( 'parts_archive_simple' ); ?>
	<?php endif;?>
<?php endif;?>

<?php
  if (! is_home() && ! is_front_page() && ! is_archive()) {
    // if (! function_exists('wp_pagenavi')) {
    //   pagination();
    // } else {
    //   global $wp_query;
    //   wp_pagenavi(array('query' => $wp_query));
    // }
    // // Reset WP_Query
    // wp_reset_postdata();
  }
?>
<?php get_template_part( 'parts_add_bottom' ); ?>
</main>
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
