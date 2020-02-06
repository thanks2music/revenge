<?php
// ウィジェット
function theme_register_sidebars_child() {
  register_sidebar(array(
    'id' => 'widget_sp_puread_home',
    'name' => 'SP: 純広告枠 (Large - ホーム)',
    'description' => 'スマホViewで表示される純広告枠です',
    'before_widget' => '<div id="%1$s" class="sp__puread %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'widget_sp_puread_small',
    'name' => 'SP: 純広告枠 (Small - 一覧)',
    'description' => 'スマホViewで表示される純広告枠です',
    'before_widget' => '<div id="%1$s" class="sp__puread %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'widget_nav_drawer',
    'name' => 'SP: AMPハンバーガーメニュー',
    'description' => 'ハンバーガーメニュー内で表示されるナビドロワーです',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'amp_footer_content',
    'name' => 'SP: AMP記事下部コンテンツ',
    'description' => 'AMP記事のフッターに表示させるコンテンツ',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'common_copyright',
    'name' => '共通: サイトのコピーライト',
    'description' => 'フッターに表示されるコピーライト',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'addbanner-sp-contentfoot',
    'name' => __( 'SP：[広告]記事コンテンツ下', 'storktheme' ),
    'description' => __( '記事コンテンツ下にAdsenseなどの広告を表示します。テキストウィジェットを追加して広告コードを貼り付けて下さい。こちらはスマートフォン用！【推奨サイズ】300×250', 'storktheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle"><span>',
    'after_title' => '</span></h4>',
  ));
}

// 人気記事
class myPopularPosts extends WP_Widget {
  function __construct() {
      parent::__construct(false, $name = '人気記事 (Theme Ver)');
    }
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $entry_num = apply_filters( 'widget_body', $instance['count'] );
        $show_num = apply_filters( 'widget_checkbox', $instance['show_num'] );
        $show_views = apply_filters( 'widget_checkbox', $instance['show_views'] );
        //以下出力されるHTML
      ?>
        <div class="widget widget__popular-posts">
          <?php if ( $title ) echo $before_title . $title . $after_title; ?>
          <?php
            $args = array(
                'post_type'     => array('post', 'event'),
                'numberposts'   => $entry_num,
                'meta_key'      => 'post_views_count',
                'orderby'       => 'meta_value_num',
                'order'         => 'DESC',
            );
            $pop_posts = get_posts( $args );

            if($pop_posts) : ?>
                <ul class="my-widget<?php if($show_num){$i = 1; echo ' show_num';}?>">
                  <?php foreach( $pop_posts as $post ) : ?>
                  <li><?php  //順位
                        if($show_num){ echo '<span class="rank dfont accent-bc">'.$i.'</span>'; $i++;} ?><a href="<?php echo get_permalink($post->ID); ?>">
                        <?php if(get_the_post_thumbnail($post->ID)): ?><figure class="my-widget__img"><?php echo get_the_post_thumbnail($post->ID, 'thumb-160'); ?></figure><?php endif; ?>
                        <div class="my-widget__text"><?php echo $post->post_title; ?><?php //views
                        if($show_views) echo '<span class="dfont views">'.get_post_meta($post->ID, 'post_views_count', true).' views</span>'; ?></div>
                      </a></li>
                  <?php endforeach; ?>
                  <?php wp_reset_postdata(); ?>
                </ul>
            <?php endif; ?>
        </div>
      <?php  } //END出力されるHTML

    //人気記事ウィジェットを出力
    function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['count'] = $new_instance['count'];
      $instance['show_num'] = $new_instance['show_num'];
      $instance['show_views'] = $new_instance['show_views'];
      return $instance;
    }

    function form($instance) {
      $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
      $entry_num = isset($instance['count']) ? $instance['count'] : '';
      $show_num = isset($instance['show_num']) ? $instance['show_num'] : '';
      $show_views = isset($instance['show_views']) ? $instance['show_views'] : '';
      ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>">
          タイトル:
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
           <label for="<?php echo $this->get_field_id('count'); ?>">
           表示する記事数
           </label>
           <input class="tiny-text" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" step="1" min="1" value="<?php echo $entry_num; ?>" size="3">
        </p>

        <p>
          <input id="<?php echo $this->get_field_id('show_num'); ?>" name="<?php echo $this->get_field_name('show_num'); ?>" type="checkbox" value="1" <?php checked( $show_num, 1 ); ?>/>
          <label for="<?php echo $this->get_field_id('show_num'); ?>">順位を表示する</label>
        </p>
        <p>
          <input id="<?php echo $this->get_field_id('show_views'); ?>" name="<?php echo $this->get_field_name('show_views'); ?>" type="checkbox" value="1" <?php checked( $show_views, 1 ); ?>/>
          <label for="<?php echo $this->get_field_id('show_views'); ?>">累計閲覧数を表示</label>
        </p>
        <?php
    }
}
add_action( 'widgets_init', function () {
	register_widget( 'myPopularPosts' );
} );

//ウィジェット内でショートコードを使用可能に
add_filter('widget_text', 'do_shortcode');


// カテゴリの投稿数をaタグの中に
add_filter( 'wp_list_categories', 'my_list_categories_child', 10, 2 );
function my_list_categories_child( $output, $args ) {
  $output = preg_replace('/<\/a>\s*\((\b\d{1,3}(,\d{3})*\b)\)/',' <span class="count">($1)</span></a>',$output);
  return $output;
}

// アーカイブの投稿数をaタグの中に
add_filter( 'get_archives_link', 'my_archives_link_child' );
function my_archives_link_child( $output ) {
  $output = preg_replace('/<\/a>\s*(&nbsp;)\((\d+)\)/',' ($2)</a>',$output);
  return $output;
}

// 新着記事のフォーマットを変更
class My_Recent_Posts_Widget_Child extends WP_Widget_Recent_Posts {
	function widget($args, $instance) {
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
		if( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
			$number = 10;
		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if( $r->have_posts() ) :
			echo $before_widget;
			if( $title ) echo $before_title . $title . $after_title; ?>
			<ul>
				<?php while( $r->have_posts() ) : $r->the_post(); ?>
				<li>
					<a class="cf" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
						<?php if ( $show_date ) : ?><span class="date gf"><?php the_time('Y.m.d'); ?></span><?php endif; ?>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
			<?php
			echo $after_widget;
		wp_reset_postdata();
		endif;
	}
}
function my_recent_widget_registration_child() {
  unregister_widget('WP_Widget_Recent_Posts');
  register_widget('My_Recent_Posts_Widget_Child');
}
add_action('widgets_init', 'my_recent_widget_registration_child');


//画像付き新着記事ウィジェット追加
///////////////////////////////////
class NewEntryImageWidgetChild extends WP_Widget {
  public function __construct() {
    parent::__construct(false, $name = '[画像付き] 最新の投稿 (Child)');
  }
  function widget($args, $instance) {
    extract( $args );
    $title_new = apply_filters( 'widget_title_new', $instance['title_new'] );
    $entry_count = apply_filters( 'widget_entry_count', $instance['entry_count'] );
    global $g_entry_count; 
    $g_entry_count = 5;//表示数が設定されていない時は5にする
    if ($entry_count) {//表示数が設定されているときは表示数をグローバル変数に代入
      $g_entry_count = $entry_count;
    }
    ?>
      <div id="new-entries" class="widget widget_recent_entries widget_new_img_post cf">
        <h4 class="widgettitle widget__title"><span><?php if ($title_new) {
          echo $title_new;//タイトルが設定されている場合は使用する
        } else {
          echo '新着エントリー';
        }
        ?></span></h4>
    <ul class="widget__new-entry">
    <?php
      // グローバル変数の呼び出し
      global $g_entry_count;
      $args = array(
        'post_type' => array('post', 'event'),
        'posts_per_page' => $g_entry_count,
      );
    ?>
    <?php
      // クエリの作成
      query_posts($args);
      global $post;
    ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <li>
    <a class="cf" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
    <figure class="eyecatch">
      <?php if (! empty($_GET['amp']) && $_GET['amp'] === '1') {
        $amp_img = '';
        $image_array = get_the_thumbnail_image_array($post->ID);
        $title = get_the_title();
        $amp_img .= '<amp-img src="'.$image_array[0].'" layout="responsive" width="'.$image_array[1].'" height="'.$image_array[2].'" alt="'.$title.'"></amp-img>';

        echo $amp_img;
        } else {
          the_post_thumbnail('home-thum');
        }
      ?>
    </figure>
    <?php else: ?>
    <figure class="eyecatch noimg">
      <img src="<?php echo get_template_directory_uri(); ?>/library/images/noimg.png">
    </figure>
    <?php endif; ?>
    <p class="widget__post-title"><?php the_title(); ?></p>
    <span class="date gf widget__post-date">
      <?php the_time('Y.m.d'); ?>
      <i class="fa fa-chevron-circle-right"></i>
    </span>
    </a>
    </li>
    <?php endwhile; 
    else :
      echo '<p>新着記事はありません。</p>';
    endif; ?>
    <?php wp_reset_query(); ?>
    </ul>
        </div><!-- /#new-entries -->
      <?php
  }
  function update($new_instance, $old_instance) {
   $instance = $old_instance;
   $instance['title_new'] = strip_tags($new_instance['title_new']);
   $instance['entry_count'] = strip_tags($new_instance['entry_count']);
      return $instance;
  }
  function form($instance) {
      $title_new = esc_attr($instance['title_new']);
      $entry_count = esc_attr($instance['entry_count']);
      ?>
      <?php //タイトル入力フォーム ?>
      <p>
        <label for="<?php echo $this->get_field_id('title_new'); ?>">
        <?php _e('新着エントリーのタイトル'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('title_new'); ?>" name="<?php echo $this->get_field_name('title_new'); ?>" type="text" value="<?php echo $title_new; ?>" />
      </p>
      <?php //表示数入力フォーム ?>
      <p>
        <label for="<?php echo $this->get_field_id('entry_count'); ?>">
        <?php _e('表示数（半角数字）'); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('entry_count'); ?>" name="<?php echo $this->get_field_name('entry_count'); ?>" type="text" value="<?php echo $entry_count; ?>" />
      </p>
      <?php
  }
}
add_action( 'widgets_init', function(){
  return register_widget( "NewEntryImageWidgetChild" );
});
