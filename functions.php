<?php

// 子テーマのstyle.cssを後から読み込む
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  global $dir;
  $time_stamp = time();
  wp_enqueue_style('style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('webfont-amatic', 'https://fonts.googleapis.com/css?family=Amatic+SC');

  wp_enqueue_style('child-style',
    $dir['theme'] . '/dist/css/main.css?' . $time_stamp,
    array('style')
  );
}

// Global Variable
locate_template('config/variables.php', true);

// JavaScriptを指定する関数
add_action('wp_footer', 'add_javascripts');
function add_javascripts() {
  global $dir;
  $time_stamp = time();
  wp_enqueue_script('app', $dir['theme'] . '/dist/min/app.js?' . $time_stamp);
}

// MOREタグの下に広告を表示
add_filter('the_content', 'adMoreReplace');

function adMoreReplace($contentData) {
  global $is_sp;
  $adTagResponsive = '';
  $adTagText = '';

  // SP
  // レスポンシブ広告
  if ($is_sp) {
$adTagResponsive = <<< EOF

<div class="add more">
  <ins class="adsbygoogle"
       style="display:block; text-align:center;"
       data-ad-format="fluid"
       data-ad-layout="in-article"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="2805411615"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;
    // PC
  } else {
$adTagResponsive = <<< EOF

<div class="add more">
  <ins class="adsbygoogle"
       style="display:block; text-align:center;"
       data-ad-format="fluid"
       data-ad-layout="in-article"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="2805411615"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;
  }

// テキスト広告
$adTagText = <<< EOF

<div class="add more text">
  <!-- CC - レスポンシブテキスト -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="9384949215"
       data-ad-format="auto"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;

  // レスポンシブ広告
  $contentData = preg_replace('/<p><span id="more-([0-9]+?)"><\/span>(.*?)<\/p>/i', $adTagResponsive, $contentData);
  // テキスト広告
  $contentData = str_replace('<p><moreads></moreads></p>', $adTagText, $contentData);
  $contentData = str_replace('<p></p>', '', $contentData);
  $contentData = str_replace('<p><br />', '<p>', $contentData);

  return $contentData;
}

// パンくず
if (! function_exists('breadcrumb')) {
	function breadcrumb($divOption = array("id" => "breadcrumb", "class" => "breadcrumb inner wrap cf")) {
    global $post;
    $str ='';
    if (! get_option('side_options_pannavi')){
      if (! is_home() && ! is_front_page() && ! is_admin()) {
          $tagAttribute = '';
          $itemLength = 1;
          foreach($divOption as $attrName => $attrValue){
              $tagAttribute .= sprintf(' %s="%s"', $attrName, $attrValue);
          }
          $str.= '<div'. $tagAttribute .'>';
          $str.= '<ul itemscope itemtype="http://schema.org/BreadcrumbList">';
          $str.= '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. home_url() .'/" itemprop="item"><i class="fa fa-home"></i><span itemprop="name">HOME</span></a>';
          $str.= '<meta itemprop="position" content="' . $itemLength . '" /></li>';
          $itemLength++;

          if (is_archive()) {
            $cat = get_queried_object();

            // カテゴリーアーカイブ
            // 親カテゴリがある場合
            if (isset($cat->parent)) {
              // カスタムタクソノミーの場合
              if (isset($cat->taxonomy) && isset($cat->term_id)) {
                $ancestors = array_reverse(get_ancestors($cat->term_id, 'event-category', 'taxonomy'));
                // デフォルト投稿の場合
              } else {
                $ancestors = array_reverse(get_ancestors($cat->cat_ID, 'category'));
              }

              foreach($ancestors as $ancestor) {
                $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. get_category_link($ancestor) .'" itemprop="item"><span itemprop="name">'. get_cat_name($ancestor) .'</span></a></li>';
                $str.= '<meta itemprop="position" content="' . $itemLength . '" /></li>';
                $itemLength++;
              }
            }

            // 投稿アーカイブの場合
            if (isset($cat->name) && $cat->name === 'event') {
              $cat->name = 'コラボイベント記事一覧';
            }

            $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="' . (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] .'" itemprop="item"><span itemprop="name">'. $cat -> name . '</span><meta itemprop="position" content="' . $itemLength . '" /></a></li>';
          } elseif (is_single()) {
            $post_type = get_post_type();
            $taxonomy_name = 'category';
            if ($post_type === 'event') {
              $taxonomy_name = 'event-category';
            }

            $categories = get_the_terms($post->ID, $taxonomy_name);
            $cat_len = count($categories);
            $ignore_parent = '';

            for ($i= 0; $i < $cat_len; $i++) {
              $slug = $categories[$i]->slug;
              $des = $categories[$i]->description;

              if ($categories[$i]->parent === 0 && $slug !== 'collabo-period' && $slug !== 'cafe') {
                $cat = $categories[$i];
                break;
              }
            }

            if (isset($cat)) {
                $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, $taxonomy_name));
                foreach($ancestors as $ancestor){
                  $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. get_category_link($ancestor) .'" itemprop="item"><span itemprop="name">'. get_cat_name($ancestor) .'</span></a>';
                  $str.= '<meta itemprop="position" content="' . $itemLength . '" /></li>';
                  $itemLength++;
                }
            }

            // Category
            if ($post_type === 'post') {
              $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. get_category_link($ancestor) .'" itemprop="item"><span itemprop="name">'. get_cat_name($ancestor) .'</span></a>';
              $str.= '<meta itemprop="position" content="' . $itemLength . '" /></li>';
              $itemLength++;
              // Taxonomy
            } else {
              $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. get_term_link($cat->term_taxonomy_id, $taxonomy_name) .'" itemprop="item"><span itemprop="name">'. $cat->name .'</span></a>';
              $str.= '<meta itemprop="position" content="' . $itemLength . '" /></li>';
              $itemLength++;
            }

            $str.= '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="' . (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] .'" itemprop="item"><span itemprop="name">'. $post -> post_title .'</span></a><meta itemprop="position" content="' . $itemLength . '" /></li>';
            $itemLength++;
          } elseif(is_page()){
              if($post -> post_parent != 0 ){
                  $ancestors = array_reverse(get_post_ancestors( $post->ID ));
                  foreach($ancestors as $ancestor){
                    $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. get_permalink($ancestor).'" itemprop="item"><span itemprop="name">'. get_the_title($ancestor) .'</span></a>';
                    $str.= '<meta itemprop="position" content="' . $itemLength . '" /></li>';
                    $itemLength++;
                  }
              }

              $str.= '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="' . (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] .'" itemprop="item"><span itemprop="name">'. $post -> post_title .'</span></a><meta itemprop="position" content="' . $itemLength . '" /></li>';
          } elseif(is_date()){
        if( is_year() ){
          $str.= '<li>' . get_the_time('Y') . '年</li>';
        } else if( is_month() ){
          $str.= '<li><a href="' . get_year_link(get_the_time('Y')) .'">' . get_the_time('Y') . '年</a></li>';
          $str.= '<li>' . get_the_time('n') . '月</li>';
        } else if( is_day() ){
          $str.= '<li><a href="' . get_year_link(get_the_time('Y')) .'">' . get_the_time('Y') . '年</a></li>';
          $str.= '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('n') . '月</a></li>';
          $str.= '<li>' . get_the_time('j') . '日</li>';
        }
        if(is_year() && is_month() && is_day() ){
          $str.= '<li>' . wp_title('', false) . '</li>';
        }
          } elseif(is_search()) {
              $str.='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><span itemprop="title">「'. get_search_query() .'」で検索した結果</span></li>';
          } elseif(is_author()){
              $str .='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><span itemprop="title">投稿者 : '. get_the_author_meta('display_name', get_query_var('author')).'</span></li>';
          } elseif(is_tag()){
              $str.='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><span itemprop="title">タグ : '. single_tag_title( '' , false ). '</span></li>';
          } elseif(is_attachment()){
              $str.= '<li><span itemprop="title">'. $post -> post_title .'</span></li>';
          } elseif(is_404()){
              $str.='<li>ページがみつかりません。</li>';
          } else{
              $str.='<li></li>';
          }
          $str.='</ul>';
          $str.='</div>';
      }
  }
    echo $str;
	}
}

// サーチフォームのDOM
if (! function_exists('my_search_form')) {
  function my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform cf" action="' . home_url( '/' ) . '" >
    <input type="search" placeholder="検索する" value="' . get_search_query() . '" name="s" id="s" />
    <button type="submit" id="searchsubmit" ><i class="fa fa-search"></i></button>
    </form>';
    return $form;
  }
  add_filter( 'get_search_form', 'my_search_form' );
}

//サイト内検索をカスタマイズ
if (! function_exists('SearchFilter')) {
  function SearchFilter($query) {
  if ($query->is_search && $query->is_main_query() && !is_admin()) {
    $query->set('post_type', array('post', 'page', 'event'));
  }
  return $query;
  }
  add_filter('pre_get_posts','SearchFilter');
}

if (!function_exists('pagination')) {
  function pagination($pages = '', $range = 2){
    global $wp_query, $paged;
    $big = 999999999;

    echo "<nav class=\"pagination cf\">\n";
    echo paginate_links( array(
      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'current' => max( 1, get_query_var('paged') ),
      'prev_text'    => __('<'),
      'next_text'    => __('>'),
      'type'    => 'list',
      'total' => $wp_query->max_num_pages
    ) );
    echo "</nav>\n";
  }
}
add_action('pre_get_posts', 'home_posts_type');
function home_posts_type($wp_query) {
  if (! is_admin() && $wp_query->is_main_query() && $wp_query->is_home()) {
    $wp_query->set('post_type', array('post', 'event'));
  }
}

// レスポンシブイメージを停止
add_filter( 'wp_calculate_image_srcset', '__return_false' );

// the_post_thumbnailの引数に「class」をつけて呼び出す
// classに「lazy」をつけるとlazyLoadの対象になる
function modify_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
  $id = get_post_thumbnail_id(); // gets the id of the current post_thumbnail (in the loop)
  $src = wp_get_attachment_image_src($id, $size); // gets the image url specific to the passed in size (aka. custom image size)
  //  [1]=> int(1280) [2]=> int(794
  $width = $src[1];
  $height = $src[2];
  $alt = get_the_title(); // gets the post thumbnail title
  $class = '';
  if (isset($attr['class'])) {
    $class = $attr['class']; // gets classes passed to the post thumbnail, defined here for easier function access
  }

  // Check to see if a 'retina' class exists in the array when calling "the_post_thumbnail()", if so output different <img/> html
  if (strpos($class, 'lazy') !== false) {
    $html = '<img src="/wp-content/uploads/dummy.png" alt="" data-src="' . $src[0] . '" alt="' . $alt . '" class="' . $class . '" width="' . $width . '" height="' . $height . '" />';
  } else {
    $html = '<img src="' . $src[0] . '" alt="' . $alt . '" class="' . $class . '" width="' . $width . '" height="' . $height . '" />';
  }

  return $html;
}
add_filter('post_thumbnail_html', 'modify_post_thumbnail_html', 99, 5);

// 独自アイキャッチ画像
// サーバーに負荷かかるがリクエストサイズがでかくなるので、サムネイルはトリミングする
if (! function_exists('add_mythumbnail_size')) {
	function add_mythumbnail_size() {
	add_theme_support('post-thumbnails');
	add_image_size('period-thum', 672, 416, true);
	add_image_size('home-thum', 486, 290, true);
	add_image_size('post-thum', 300, 200, true);
	}
	add_action( 'after_setup_theme', 'add_mythumbnail_size' );
}
