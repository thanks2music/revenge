<?php
//子テーマのCSSの読み込み
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'child-style', 
  	get_stylesheet_directory_uri() . '/style.css', 
  	array('sng-stylesheet','sng-option')
	);
}
/************************
 *function.phpへの追記は以下に
 *************************/




/************************
 *function.phpへの追記はこの上に
 *************************/
?>