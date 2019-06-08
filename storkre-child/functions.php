<?php global $amp_flag;
require_once( 'library/widget.php' );
require_once( 'library/customizer.php' );
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

// Override WordPress Setting
// if $amp_flag 内でネストするとremove_actionが動作しないのでどうにかする

if (! empty($_GET['amp'])) {
  if ($_GET['amp'] === '1') {
    remove_action('wp_head','rest_output_link_wp_head');
    remove_action('wp_head','wp_oembed_add_discovery_links');
    remove_action('wp_head','wp_oembed_add_host_js');
    remove_filter('the_content', array($wp_embed, 'autoembed'), 8);
  }
}

add_action( 'widgets_init', 'theme_register_sidebars_child' );

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
global $is_sp, $amp_flag;
$adTagResponsive = '';
$adTagText = '';

if ($_GET['amp'] === '1') {
$adTagResponsive = <<< EOF

<div class="amp__ad--responsive">
<amp-ad
   layout="responsive"
   width=300
   height=250
   type="adsense"
   data-ad-client="ca-pub-7307810455044245"
   data-ad-slot="2805411615">
</amp-ad>
</div>

EOF;
} else {
$adTagResponsive = <<< EOF

<div class="ad__in-post--more">
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

// moreads広告
if ($_GET['amp'] === '1') {
$adTagText = <<< EOF

<div class="amp__ad--responsive">
<amp-ad
   layout="responsive"
   width=300
   height=250
   type="adsense"
   data-ad-client="ca-pub-7307810455044245"
   data-ad-slot="9384949215">
</amp-ad>
</div>

EOF;
} elseif ($is_sp) {
$adTagText = <<< EOF

<div class="ad__in-post--moreads">
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
} else {
$adTagText = <<< EOF

<div class="ad__in-post__pc-moreads">
  <div class="ad__in-post__pc-moreads--left">
    <ins class="adsbygoogle"
         style="display:inline-block;width:336px;height:280px"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="8844530410"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  </div>
  <div class="ad__in-post__pc-moreads--right">
    <ins class="adsbygoogle"
         style="display:inline-block;width:336px;height:280px"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="8844530410"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  </div>
</div>

EOF;
}

// レスポンシブ広告
$contentData = preg_replace('/<p><span id="more-([0-9]+?)"><\/span>(.*?)<\/p>/i', $adTagResponsive, $contentData);
// テキスト広告
$contentData = str_replace('<p><moreads></moreads></p>', $adTagText, $contentData);
$contentData = str_replace('<p></p>', '', $contentData);
$contentData = str_replace('<p><br />', '<p>', $contentData);

return $contentData;
}

function get_html_attr($search_text, $content) {
  $_array = explode($search_text, $content);
  $end_point = strpos($_array[1], '"');
  $attr_value = substr($_array[1], 0, $end_point);

  return $attr_value;
}

function single_photoswipe_shortcode($atts, $content = null) {
  extract( shortcode_atts( array(
    'class' => '',
  ), $atts));

  $pattern = '/<img.*?data-src\s*=\s*[\"|\'](.*?)[\"|\'].*?>|<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i';
  $single_photoswipe_target = preg_match_all($pattern, $content, $matches);
  $dom_array = [];

  // Single PhotoswipeのDOMを作る
  foreach($matches[0] as $key => $value) {
    $width  = get_html_attr('width="', $value);
    $height = get_html_attr('height="', $value);
    $src    = get_html_attr('src="', $value);
    // Lazyload用のdummy.pngだったら
    if (strpos($src, 'dummy.png') !== false) {
      $src  = get_html_attr('data-src="', $value);
    }

    // a要素を作る
    $dom_array[$key] .= '<a class="single_photoswipe" data-size="';
    $dom_array[$key] .= $width . 'x' . $height;
    $dom_array[$key] .= '" href="' . $src . '">';
    // img要素
    $dom_array[$key] .= $value;
    $dom_array[$key] .= '</a>';
  }

  $content = str_replace($matches[0], $dom_array, $content);
  $content = do_shortcode(shortcode_unautop($content));
  return '<div class="photoswipe--single">' . $content . '</div>';

}
add_shortcode('single_photoswipe', 'single_photoswipe_shortcode');

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

function custom_wp_kses_allowed_html($tags, $context) {
  if ($context === 'event' || $context === 'post') {
    $tags['moreads'] = true;
    $tags['ruby'] = true;
    $tags['rp'] = true;
    $tags['rt'] = true;
  }
  return $tags;
}

add_filter('wp_kses_allowed_html', 'custom_wp_kses_allowed_html', 10, 2);

function get_the_thumbnail_image_array($post_id) {
  $image_id = get_post_thumbnail_id($post_id);
  $image_array = wp_get_attachment_image_src($image_id, 'full');
  return $image_array;
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

function get_the_work_term_name($terms) {
  $length = count($terms);
  $ignore_terms = ['cafe', 'news', 'collabo-period', 'event', 'karaoke'];
  $term_name = [];
  for($i = 0; $i < $length; $i++) {
    // 親カテゴリがあるカテゴリを除外
    if ($terms[$i]->parent === 0) {
      $term_name[] .= $terms[$i]->slug;
    }
  }

  $result = array_diff($term_name, $ignore_terms);
  $result = array_values($result);
  $work_name = '';

  for($i = 0; $i < $length; $i++) {
    if ($terms[$i]->slug === $result[0]) {
      $work_name = $terms[$i]->name;
    }
  }

  return $work_name;
}

function custom_embed_content($code) {
  global $amp_flag;
  if ($amp_flag) {
    if (strpos($code, 'twitter.com/') !== false && strpos($code, '/status/') !== false) {
      $html = '<div class="embed__twitter">' . $code . '</div>';

      return $html;
    }
  }

  return $code;
}

add_filter('embed_handler_html', 'custom_embed_content');
add_filter('embed_oembed_html', 'custom_embed_content');

function replace_tweet_url_to_amp_html($the_content) {
  global $amp_flag;

  if ($amp_flag) {
    if (strpos($the_content, 'twitter.com') !== false && strpos($the_content, '/status/') !== false) {
      $_get_tweet_url = preg_match_all("#(?:https?://)?(?:mobile.)?(?:www.)?(?:twitter.com/)?(?:\#!/)?(?:\w+)/status(?:es)?/(\d+)#i", $the_content, $url_match);

      if (! empty($url_match[0])) {
        $search_url = [];
        foreach($url_match[0] as $value) {
          $search_url[] = $value;
        }
      }

      if (! empty($url_match[1])) {
        $tweet_id = [];
        foreach($url_match[1] as $value) {
          $tweet_id[] = $value;
        }
      }

      if (! empty($tweet_id) && ! empty($search_url)) {
        foreach($tweet_id as $value) {
          $amp_html[] = '<amp-twitter width="375" height="472" layout="responsive" data-tweetid="' . $value . '"></amp-twitter>';
        }
      }

      $the_content = str_replace($search_url, $amp_html, $the_content);
    }
  }

  return $the_content;
}

add_filter('the_content', 'replace_tweet_url_to_amp_html');

function replace_img_for_amp($the_content) {
  global $amp_flag;
  $pattern_anchor = '/<a class="single_photoswipe.*?\s*=\s*[\"|\'](.*?)[\"|\'].*?>|<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i';
  $single_photoswipe_anchor = preg_match_all($pattern_anchor, $the_content, $matches);

  // [0] = a要素 / [1] = img要素
  $current_index = $target_index = 0;

  foreach($matches[0] as $key => $value) {
    if (strpos($value, 'single_photoswipe') !== false) {
      $target_index = $current_index + 1;
      $amp_lightbox_dom = $image_src = $image_size = '';

      if ($amp_flag === true) {
        $the_content = str_replace($value, '', $the_content);
        $image_size = array_slice($matches[1], $target_index, 1);

        if (empty($image_size[0])) {
          $image_size = array_slice($matches[1], $current_index, 1);
        }

        $image_size = explode('x', $image_size[0]);
        $image_src = array_slice($matches[2], $target_index, 1);

        if (! empty($image_size) && ! empty($image_src)) {
          $amp_lightbox_dom = '<amp-img 
            on="tap:lightbox2"
            role="button"
            tabindex="0"
            src="'.$image_src[0].'" 
            width="'.$image_size[0].'" 
            height="'.$image_size[1].'" 
            layout="responsive" 
            alt="">
          </amp-img>';
        }
      }
    } else if ($current_index !== $target_index) {
      $image_array = array_slice($matches[0], $key, 1);
      $width  = get_html_attr('width="', $image_array[0]);
      $height = get_html_attr('height="', $image_array[0]);
      $image_path = array_slice($matches[2], $key, 1);
      $search = $image_array[0];

      if ($amp_flag) {
        $replace = '<amp-img
          on="tap:lightbox2"
          role="button"
          tabindex="0"
          src="'.$image_path[0].'"
          width="'.$width.'"
          height="'.$height.'"
          layout="responsive"
          alt="">
        </amp-img>';
      } else {
        $replace = '<img src="/wp-content/uploads/dummy.png" data-src="'.$image_path[0].'" width="'.$width.'" height="'.$height.'" alt="">';
      }

      $the_content = str_replace($search, $replace, $the_content);
    } else {
      $image_array = array_slice($matches[0], $key, 1);
      $width  = get_html_attr('width="', $image_array[0]);
      $height = get_html_attr('height="', $image_array[0]);
      $src    = get_html_attr('src="', $image_array[0]);
      $search = $image_array[0];

      if ($amp_flag) {
        $replace = '<amp-img
          on="tap:lightbox2"
          role="button"
          tabindex="0"
          src="'.$src.'"
          width="'.$width.'"
          height="'.$height.'"
          layout="responsive"
          alt="">
        </amp-img>';

        $the_content = str_replace($search, $replace, $the_content);
      }
    }

    if ($key === $target_index && $amp_flag === true) {
      $the_content = str_replace($value, $amp_lightbox_dom, $the_content);
    }

    $current_index++;
  }

  return $the_content;
}
// デフォルトのプラグイン実行優先順位は10、ショートコードの展開が11なので、ここではショートコード展開前に置換する
add_filter('the_content', 'replace_img_for_amp');

if (! empty($_GET['amp'])) {
  if ($_GET['amp'] === '1') {
    function replace_youtube_for_amp($the_content) {
      $pattern = '/https:\/\/www\.youtube\.com\/watch\?v=([\w\-]+)/';
      $get_youtube_url = preg_match_all($pattern, $the_content, $matches);
      foreach($matches[1] as $key => $value) {
        $search = 'https://www.youtube.com/watch?v=' . $value;
        $replace = '<div class="amp__youtube"><amp-youtube width="480" height="270" layout="responsive" data-videoid="';
        $replace .= $value . '"></amp-youtube></div>';
        $the_content = str_replace($search, $replace, $the_content);
      }

      return $the_content;
    }

    function replace_video_for_amp($the_content) {
      $pattern = '/<video.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?<\/video>/i';
      $get_video_element = preg_match_all($pattern, $the_content, $matches);

      if (! empty($matches[0])) {
        foreach($matches[0] as $key => $value) {
          $poster = preg_match('/poster\s*=\s*[\"|\'](.*?)[\"|\'].*>/i', $value, $poster_path);
          $video = preg_match('/src\s*=\s*[\"|\'](.*?)[\"|\'].*>/i', $value, $video_path);
          $search = $value;
          $replace = '<div class="amp__video"><amp-video width="480" height="270" layout="responsive" src="';
          $replace .= $video_path[1] . '" poster="' . $poster_path[1] . '" controls>';
          $replace .= '<source type="video/mp4" src="' . $video_path[1] . '"></amp-video></div>';
          $the_content = str_replace($search, $replace, $the_content);
        }

        return $the_content;
      }
    }
    add_filter('the_content', 'replace_youtube_for_amp');

    if (strpos($_SERVER['REQUEST_URI'], 'usamaru-cafe2018-winter') !== false) {
      add_filter('the_content', 'replace_video_for_amp');
    }
  }
}

function is_dev() {
  $url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

  if (strpos($url, '.dev') !== false || strpos($url, '.net') !== false) {
    return true;
  } else {
    return false;
  }
}

function get_event_date($cf) {
  $date = '';
  $start = $cf['_eventorganiser_schedule_start_start'][0];
  $start = date('Y年n月j日', strtotime($start));
  $end = $cf['_eventorganiser_schedule_start_finish'][0];
  $end = date('n月j日', strtotime($end));
  $endless_flag = $cf['endless_event_flag'][0];

  if ($endless_flag) {
    $date .= $start . '〜';
  } else {
    $date .= $start . '〜' . $end;
  }

  return $date;
}

function is_prod() {
  if (! is_dev()) {
    return true;
  } else {
    return false;
  }
}

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

function minify_css($data) {
  // コメント削除
  $data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
  // コロンの後の空白を削除する
  $data = str_replace(': ', ':', $data);
  // タブ、スペース、改行などを削除する
  $data = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $data);

  return $data;
}

function get_amp_style() {
$amp_style = <<< EOF

EOF;

return $amp_style;
}
