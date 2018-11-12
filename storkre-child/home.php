<?php get_header(); ?>
<div id="content">
<div id="inner-content" class="wrap cf">

<main id="main" class="m-all t-all d-5of7 cf" role="main">
  <a class="modal__sorry__anchor js__modal--mail" href="#js__modal-sorry">お問い合わせ対応のお詫び</a>
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
<div id="js__modal-sorry" class="modal__container">
  <div class="modal__sorry">
    <a class="modal__close--top js__modal-close" href="#modal-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
    <h4>お問い合わせが正しく受信出来ていませんでした</h4>
    <p>
      メールサーバーのエラーによりお問い合わせが正しく受信出来ておりませんでした。<br>
      ご返信が遅れてしまい、誠に申し訳ございません。<br>
      以下の日時にてメールサーバーの機能が一時停止しており、<br>
      お客様へのご返信ができない状態となっておりました。<br><br>
      【問題発生時刻】<br>
      xxxx<br><br>
      【症状】<br>
      xxxx<br><br>
      上記、同様の問題が発生しないようすでに対策を行わせていただきましたが、<br>
      この度は、お客様よりお問い合わせいただいた内容にご返信することができず大変申し訳ございませんでした。<br><br>
      以後、お客様よりお問い合わせがあった際には、迅速かつ早急にご返信させていただきたいと思いますので、<br>
      今後とも本ブログを活用していただければと思います。
    </p>
    <a class="modal__close--bottom js__modal-close" href="#modal-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
  </div>
</div>
</main>
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
