<?php if (have_posts()){
/*記事一覧表示は以下の2種類（カスタマイザーから設定）
  1）横長のタイプ
  2) 通常のカードタイプ
*/
 	//(1)横長の場合
if( is_sidelong() ): ?>
		<div class="sidelong cf">
			<?php while (have_posts()) : the_post();
						sng_sidelong_card();/*sng-functions.phpで定義*/
						endwhile;
			?>
		</div>
<?php else : //(2)カードタイプの場合?>
		<div class="cardtype cf">
			<?php while (have_posts()) : the_post();
						sng_normal_card();/*sng-functions.phpで定義*/
						endwhile;
			?>
		</div>
<?php endif;
	sng_page_navi();
} else {//記事なし
	get_template_part('content', 'not-found');
}
wp_reset_query();
?>
