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

<?php if ( is_front_page() || is_home() ) { ?>
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
<div class="header__slider">
  <ul id="header__slider__ul" class="header__slider__ul">
    <?php while ($the_query->have_posts()) {
      $the_query->the_post();
    ?>
    <li class="header__slider__item">
      <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="header__slider__anchor">
        <?php
          $cat = get_the_category();
          if (isset($cat) && ! empty($cat)) {
            $cat = $cat[0];
          }
        ?>
        <?php if (has_post_thumbnail()) { ?>
          <figure class="header__slider__eyecatch">
            <?php // NOTE: 引数にclassを指定し、「lazy」classをつけると遅延読み込みの対象にする - Slickの関係でここでは対象にしていない ?> 
            <?php if (is_mobile()) { ?>
              <?php the_post_thumbnail('home-thum', array('class' => 'attachment-home-thum size-home-thum wp-post-image')); ?>
            <?php } else { ?>
              <?php the_post_thumbnail('full', array('class' => 'attachment-home-thum size-home-thum wp-post-image')); ?>
            <?php } ?>
          </figure>
        <?php } ?>
        <?php /* <h2 class="header__slider__item__title"><?php the_title(); ?></h2> */ ?>
      </a>
    </li>
  <?php } ?>
  </ul>
  <div class="header__slider__nav">
    <?php while ($the_query->have_posts()) {
      $the_query->the_post();
    ?>
    <div class="header__slider__nav__item">
      <div class="header__slider__nav__progress"></div>
      <div class="header__slider__nav__item__thumbnail"><?php the_post_thumbnail('home-thum'); ?></div>
      <h3 class="header__slider__nav__item__title"><?php the_title(); ?></h3>
    </div>
  <?php } ?>
  </div>
</div>

<?php } // end $the_query->have_posts
wp_reset_postdata();
?>
<?php } ?>
