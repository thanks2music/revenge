<?php
// カテゴリ情報から関連記事を8個ランダムに呼び出す
global $post;
$term_id = array();
$post_type = get_post_type();
$taxonomy_name = 'category';

if ($post_type === 'event') {
  $taxonomy_name = 'event-category';
}

// カスタム投稿に対応させるためget_the_termsに変更
$categories = get_the_terms($post->ID, $taxonomy_name);

foreach($categories as $category) {
  array_push($term_id, $category->term_id);
}

$args = array(
  'post__not_in' => array($post->ID),
  'posts_per_page'=> 8,
  'orderby' => 'rand',
  'tax_query' => array(
    array(
      'taxonomy' => $taxonomy_name,
      'terms' => $term_id,
      'field' => 'term_id',
      'operator'=>'IN',
    ),
  ),
);
$query = new WP_Query($args); ?>
  <?php if( $query -> have_posts() ): ?>
<div class="related-box original-related wow animated fadeIn cf remix">
    <div class="inbox">
	    <h2 class="related-h h_ttl"><span class="gf">RECOMMEND</span>こちらの記事も人気です。</h2>
		    <div class="related-post">
				<ul class="related-list cf">

  <?php while ($query -> have_posts()) : $query -> the_post(); ?>
	        <li rel="bookmark" title="<?php the_title_attribute(); ?>">
		        <a href="<?php the_permalink(); ?>" rel=\"bookmark" title="<?php the_title_attribute(); ?>" class="title">
		        	<figure class="eyecatch">
	        <?php if(has_post_thumbnail()) { ?>
	                <?php the_post_thumbnail('post-thum'); ?>
	        <?php } else { ?>
	                <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png" />
	        <?php } ?>
	        		<span class="cat-name"><?php $cat = get_the_category(); ?><?php $cat = $cat[0]; ?><?php echo get_cat_name($cat->term_id); ?></span>
		            </figure>
					<time class="date gf"><?php the_time( 'Y.n.j' ); ?></time>
					<h3 class="ttl">
						<?php if(mb_strlen($post->post_title)>38) { $title= mb_substr($post->post_title,0,36) ; echo $title. "…" ;
						} else {echo $post->post_title;}?>
					</h3>
				</a>
	        </li>
  <?php endwhile;?>

  			</ul>
	    </div>
    </div>
</div>
  <?php else:?>
<div class="related-box cf">
    <div class="inbox">
	    <h2 class="related-h h_ttl"><span class="gf">Recommend</span>関連記事</h2>
	    <p class="related-none-h">関連記事は見つかりませんでした。</p>
	</div>
</div>
  <?php
endif;
wp_reset_postdata();
?>
