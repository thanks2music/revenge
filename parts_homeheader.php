<?php if ( get_option( 'opencage_toppage_headeregtext' ) || get_option( 'opencage_toppage_headerjptext' ) ) : ?>
<?php if ( is_front_page() && !is_paged() ) : ?>

<div id="custom_header" class="<?php echo esc_html(get_option('opencage_toppage_textlayout')); ?>" style="color:<?php echo get_theme_mod('opencage_toppage_textcolor');?>; background-image: url(<?php if ( get_theme_mod('opencage_toppage_headerbgsp') && is_mobile()):?><?php echo get_theme_mod('opencage_toppage_headerbgsp');?><?php else:?><?php echo get_theme_mod('opencage_toppage_headerbg');?><?php endif;?>); background-position: center center; background-repeat:<?php echo get_option('opencage_toppage_headerbgrepeat');?>; background-size:<?php echo get_option('opencage_toppage_headerbgsize');?>;">

	<div class="wrap cf" style="opacity: 0;">
		<div class="header-text">
			<?php if ( get_option( 'opencage_toppage_headeregtext' )) : ?>
			<h2 class="en gf wow animated fadeInDown" data-wow-delay="0.5s"><?php echo get_option( 'opencage_toppage_headeregtext' ); ?></h2>
			<?php endif; ?>
			<?php if ( get_option( 'opencage_toppage_headerjptext' )) : ?>
			<p class="ja wow animated fadeInUp" data-wow-delay="0.8s"><?php echo get_option( 'opencage_toppage_headerjptext' ); ?></p>
			<?php endif; ?>
			<?php if ( get_option( 'opencage_toppage_headerlink' )) : ?>
			<p class="btn-wrap simple maru wow animated fadeInUp" data-wow-delay="1s"><a style="color:<?php echo get_theme_mod( 'opencage_toppage_btncolor' ); ?>;background:<?php echo get_theme_mod( 'opencage_toppage_btnbgcolor' ); ?>;" href="<?php echo get_option( 'opencage_toppage_headerlink' ); ?>"><?php if ( get_option( 'opencage_toppage_headerlinktext' )) : ?><?php echo get_option( 'opencage_toppage_headerlinktext' ); ?><?php else:?>詳しくはこちら<?php endif;?></a></p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if ( is_front_page() || is_home() ) : ?>
<?php
$args = array(
    'post_type' => array('post', 'event'),
    'posts_per_page' => 16,
    'tax_query' => array(
      'relation' => 'OR',
      array(
        'taxonomy' => 'post_tag',
        'terms' => 'pickup',
        'field' => 'slug',
      ),
      array(
        'taxonomy' => 'event-tag',
        'terms' => 'pickup',
        'field' => 'slug',
      ),
    ),
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
	?>
<div id="top_carousel" class="carouselwrap wrap cf">
<ul class="slider slickcar">

<?php while ($the_query->have_posts()) {
$the_query->the_post();
?>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
<?php
$cat = get_the_category();

if (isset($cat) && ! empty($cat)) {
  $cat = $cat[0];
}
?>
<?php if ( has_post_thumbnail()) : ?>
<figure class="eyecatch">
<?php the_post_thumbnail('home-thum'); ?>
<?php if (isset($cat) && ! empty($cat)) { ?>
  <span class="osusume-label cat-name cat-id-<?php echo $cat->cat_ID;?>"><?php echo $cat->name; ?></span>
<?php } ?>
</figure>
<?php else: ?>
<figure class="eyecatch noimg">
<img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
<span class="osusume-label cat-name cat-id-<?php echo $cat->cat_ID;?>"><?php echo $cat->name; ?></span>
</figure>
<?php endif; ?>
<h2 class="h2 entry-title"><?php the_title(); ?></h2>
</a></li>
<?php } ; ?>
</ul>
</div>
<?php }
wp_reset_postdata();
?>
<?php endif; ?>

