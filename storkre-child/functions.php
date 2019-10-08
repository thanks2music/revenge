<?php
require_once('library/widget.php');
require_once('library/customizer.php');

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
global $amp_flag, $is_sp, $is_pc;

// Cleanup unused meta tags
locate_template('config/cleanup.php', true);

// Override WordPress Setting
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

// <moreads>をADXとアドセンスに置き換える
// add_filter('the_content', 'adMoreReplace');

function get_moreads_tags($device) {
$moretags = [];
// AMP - CC_AMP_Article1_Responsive
$moretags['amp'][] = <<< EOF

<div class="amp__ad--responsive">
  <amp-ad width="100vw" height=320
       type="adsense"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="9384949215"
       data-auto-format="rspv"
       data-full-width>
    <div overflow></div>
  </amp-ad>
</div>

EOF;

// AMP - CC_AMP_Article2_Responsive
$moretags['amp'][] = <<< EOF

<div class="amp__ad--responsive">
  <amp-ad width="100vw" height=320
       type="adsense"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="9550504112"
       data-auto-format="rspv"
       data-full-width>
    <div overflow></div>
  </amp-ad>
</div>

EOF;

// AMP - CC_AMP_Article3_Responsive
$moretags['amp'][] = <<< EOF

<div class="amp__ad--responsive">
  <amp-ad width="100vw" height=320
       type="adsense"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="8217187247"
       data-auto-format="rspv"
       data-full-width>
    <div overflow></div>
  </amp-ad>
</div>

EOF;

// AMP - CC_AMP_Article4_Responsive
$moretags['amp'][] = <<< EOF

<div class="amp__ad--responsive">
  <amp-ad width="100vw" height=320
       type="adsense"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="8171999950"
       data-auto-format="rspv"
       data-full-width>
    <div overflow></div>
  </amp-ad>
</div>

EOF;

// SP - CC_SP_Article2_Responsive
// NOTE: 1はウィジェットで記事アイキャッチ下に入れている
$moretags['sp'][] = <<< EOF

<div class="ad__adx__sp">
  <!-- CC_SP_Article2_Responsive -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="3970395448"
       data-ad-format="auto"
       data-full-width-responsive="true"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;

// SP - CC_SP_Article3_Responsive
$moretags['sp'][] = <<< EOF

<div class="ad__adx__sp">
  <!-- CC_SP_Article3_Responsive -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="6876185418"
       data-ad-format="auto"
       data-full-width-responsive="true"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;

// SP - CC_SP_Article4_Responsive
$moretags['sp'][] = <<< EOF

<div class="ad__adx__sp">
  <!-- CC_SP_Article4_Responsive -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="7718068766"
       data-ad-format="auto"
       data-full-width-responsive="true"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;

// SP - CC_SP_Article5_Responsive
$moretags['sp'][] = <<< EOF

<div class="ad__adx__sp">
  <!-- CC_SP_Article5_Responsive -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="1839056121"
       data-ad-format="auto"
       data-full-width-responsive="true"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;

// PC - CC_PC_Article_2
// NOTE: 1はウィジェットで記事アイキャッチ下に入れている
$moretags['pc'][] = <<< EOF

<div class="ad__in-post__pc-moreads">
  <div class="ad__in-post__pc-moreads--left">
    <!-- CC_PC_Article_2_Left_Responsive -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="4422607039"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
  <div class="ad__in-post__pc-moreads--right">
    <!-- CC_PC_Article_2_Right_Fixed -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:336px;height:280px"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="8039430178"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
</div>

EOF;

// PC - CC_PC_Article_3
$moretags['pc'][] = <<< EOF

<div class="ad__in-post__pc-moreads">
  <div class="ad__in-post__pc-moreads--left">
    <!-- CC_PC_Article_3_Left_Responsive -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="8809586366"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
  <div class="ad__in-post__pc-moreads--right">
    <!-- CC_PC_Article_3_Right_Fixed -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:336px;height:280px"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="5274376475"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
</div>

EOF;

// PC - CC_PC_Article_4
$moretags['pc'][] = <<< EOF

<div class="ad__in-post__pc-moreads">
  <div class="ad__in-post__pc-moreads--left">
    <!-- CC_PC_Article_4_Left_Responsive -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="2648213136"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
  <div class="ad__in-post__pc-moreads--right">
    <!-- CC_PC_Article_4_Right_Fixed -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:336px;height:280px"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="1234348675"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
</div>

EOF;

// PC - CC_PC_Article_5
$moretags['pc'][] = <<< EOF

<div class="ad__in-post__pc-moreads">
  <div class="ad__in-post__pc-moreads--left">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="4413127464"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
  <div class="ad__in-post__pc-moreads--right">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7307810455044245"
         data-ad-slot="1595392432"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
</div>

EOF;

if ($device === 'pc') {
  return $moretags['pc'];
} else if ($device === 'sp') {
  return $moretags['sp'];
} else if ($device === 'amp') {
  return $moretags['amp'];
} else {
  return $moretags;
}
}

// AMPだけ実行
if (! empty($_GET['amp']) && $_GET['amp'] === '1') {
  function replace_amp_moreads($the_content) {
    $pattern = '/<p><moreads><\/moreads><\/p>/is';
    $serach_moreads = preg_match_all($pattern, $the_content, $moreads_content);
    $moreads_count_inpost = count($moreads_content[0]);
    $moreads = get_moreads_tags('amp');
    $moreads_tag_count = count($moreads);

    if ($moreads_tag_count < $moreads_count_inpost) {
      $diff_count = $moreads_count_inpost - $moreads_tag_count;
      $end_tags = end($moreads);

      for($i = 0; $i < $diff_count; $i++){
        $moreads[] = $end_tags;
      }
    }

    foreach ($moreads as $index => $value) {
      $the_content = preg_replace($pattern, $moreads[$index], $the_content, 1);
    }

    return $the_content;
  }

  add_filter('the_content', 'replace_amp_moreads');
  // SPだけ実行
} else if ($is_sp) {
  function replace_sp_moreads($the_content) {
    $pattern = '/<p><moreads><\/moreads><\/p>/is';
    $serach_moreads = preg_match_all($pattern, $the_content, $moreads_content);
    $moreads_count_inpost = count($moreads_content[0]);
    $moreads = get_moreads_tags('sp');
    $moreads_tag_count = count($moreads);

    if ($moreads_tag_count < $moreads_count_inpost) {
      $diff_count = $moreads_count_inpost - $moreads_tag_count;
      $end_tags = end($moreads);

      for($i = 0; $i < $diff_count; $i++){
        $moreads[] = $end_tags;
      }
    }

    foreach ($moreads as $index => $value) {
      $the_content = preg_replace($pattern, $moreads[$index], $the_content, 1);
    }

    return $the_content;
  }

  add_filter('the_content', 'replace_sp_moreads');
  // PCだけ実行
} else if ($is_pc) {
  function replace_pc_moreads($the_content) {
    $pattern = '/<p><moreads><\/moreads><\/p>/is';
    $serach_moreads = preg_match_all($pattern, $the_content, $moreads_content);
    $moreads_count_inpost = count($moreads_content[0]);
    $moreads = get_moreads_tags('pc');
    $moreads_tag_count = count($moreads);

    if ($moreads_tag_count < $moreads_count_inpost) {
      $diff_count = $moreads_count_inpost - $moreads_tag_count;
      $end_tags = end($moreads);

      for($i = 0; $i < $diff_count; $i++){
        $moreads[] = $end_tags;
      }
    }

    foreach ($moreads as $index => $value) {
      $the_content = preg_replace($pattern, $moreads[$index], $the_content, 1);
    }

    return $the_content;
  }

  add_filter('the_content', 'replace_pc_moreads');
}

function cosmetic_change_the_content($the_content) {
// 不要なタグを除去
$the_content = str_replace('<p></p>', '', $the_content);
$the_content = str_replace('<p><br />', '<p>', $the_content);

return $the_content;
}

function convert_kana_content($data) {
  $convert_fields = array('post_title', 'post_content');
  foreach ($convert_fields as $convert_field) {
    $data[$convert_field] = mb_convert_kana( $data[$convert_field], 'asKV', 'UTF-8' );
  }
  return $data;
}
add_filter('wp_insert_post_data', 'convert_kana_content');

add_filter('the_content', 'cosmetic_change_the_content');

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

// カスタムタクソノミーに独自入力欄を追加
add_action('event-category_edit_form_fields','add_taxonomy_fields');

function add_taxonomy_fields($term) {
 $term_id = $term->term_id; //タームID
 $taxonomy = $term->taxonomy; //タームIDに所属しているタクソノミー名
 //すでにデータが保存されている場合はDBから取得する
 $term_meta = get_option( $term->taxonomy . '_' . $term_id );
?>
 <tr class="form-field">
  <th scope="row"><label for="term_meta[]">作品から探す用画像</label></th>
  <td><textarea name="term_meta[title_image]" id="term_meta[title_image]" rows="5" cols="50" class="large-text"><?php echo isset($term_meta['title_image']) ? esc_attr( $term_meta['title_image'] ) : ''; ?></textarea>
  <p class="description">画像のURLを設定します。</p></td>
 </tr>
 <tr class="form-field">
  <th scope="row"><label for="term_meta[]">作品から探す欄の順序制御</label></th>
  <td><textarea type="text" name="term_meta[title_order]" id="term_meta[title_order]" rows="1" cols="50" class="large-text"><?php echo isset($term_meta['title_order']) ? esc_attr( $term_meta['title_order'] ) : ''; ?></textarea>
  <p class="description">半角数字で整数を指定してください</p></td>
 </tr>
<?php
}

// カスタムタクソノミーの入力欄の保存
add_action( 'edited_term', 'save_taxonomy_fileds' );

function save_taxonomy_fileds( $term_id ) {
 global $taxonomy; //タクソノミー名を取得
 if ( isset( $_POST['term_meta'] ) ) { //自由入力欄に値が入っていたら処理する
  $term_meta = get_option( $taxonomy . '_' . $term_id );
  $term_keys = array_keys($_POST['term_meta']);

  foreach ($term_keys as $key){
   if (isset($_POST['term_meta'][$key])){
    $term_meta[$key] = stripslashes_deep( $_POST['term_meta'][$key] );
   }
  }
  update_option( $taxonomy . '_' . $term_id, $term_meta ); //保存
 }
}

add_action('rest_api_init', 'add_custom_fields_to_rest' );
function add_custom_fields_to_rest() {
  register_rest_field(
    'event', 
    'custom_fields',
    [
      'get_callback'    => 'get_custom_fields_value', // カスタム関数名指定 
      'update_callback' => null,
      'schema'          => null,
    ]
  );

  register_rest_field(
    'event-category', 
    'term_fields',
    [
      'get_callback'    => function($object, $field_name, $request) {
        $meta = '';
        $meta = get_option($object['taxonomy'] . '_' . $object['id']);
        return $meta;
      },
      'update_callback' => null,
      'schema'          => null,
    ]
  );
}


function my_filter_rest_endpoints($endpoints) {
  if (isset($endpoints['/wp/v2/users'])) {
    unset($endpoints['/wp/v2/users']);
  }
  if (isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)']) ) {
    unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
  }
  return $endpoints;
}
add_filter('rest_endpoints', 'my_filter_rest_endpoints', 10, 1);

function get_custom_fields_value() {
  return get_post_custom();
}

function is_app($key = 'layout') {
  if (isset($_GET[$key])) {
    $query = $_GET[$key];

    if ($query === 'app') {
      return true;
    } else {
      return false;
    }
  }

  return false;
}

function is_web() {
  if (! is_app()) {
    return true;
  } else {
    return false;
  }
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
                $cat_name = get_cat_name($ancestor);

                $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. get_category_link($ancestor) .'" itemprop="item"><span itemprop="name">';

                if (empty($cat_name)) {
                  $str .= get_the_category_by_ID($ancestor);
                } else {
                  $str.= $cat_name;
                }

                $str.= '</span><meta itemprop="position" content="' . $itemLength . '" /></a></li>';
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

              if (! empty($cat) && $post_type === 'post') {
                $cat = $categories[0];
              }

            if (isset($cat)) {
              $ancestors = array_reverse(get_ancestors($cat->term_id, $taxonomy_name));

              foreach($ancestors as $ancestor) {
                $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. get_category_link($ancestor) .'" itemprop="item"><span itemprop="name">'. get_cat_name($ancestor) .'</span></a>';
                $str.= '<meta itemprop="position" content="' . $itemLength . '" /></li>';
                $itemLength++;
              }
            }

            // Category
            if ($post_type === 'post') {
              $str.='<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="'. get_category_link($cat->term_id) .'" itemprop="item"><span itemprop="name">'. get_cat_name($cat->term_id) .'</span></a>';
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

// Simple GA Ranking
if (function_exists('sga_ranking_get_date')) {
  //サムネイル生成
  function sga_ranking_thumbnail_image($thumbnail, $id) {
   $post_url = get_permalink($id);
   $title = get_the_title($id);
   $thumbnail = '';

   if (has_post_thumbnail($id)) {
     $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'home-thum');
     $post_thumb_url = $post_thumb[0];
     $post_thumb_width = $post_thumb[1];
     $post_thumb_height = $post_thumb[2];
     $thumbnail = '<figure class="sga-ranking__thumbnail"><a href="'.$post_url.'" title="'.$title.'"><img src="'.$post_thumb_url.'" alt="'.$title.'" width="'.$post_thumb_width.'" height="'.$post_thumb_height.'"></a></figure>';
   }

   return $thumbnail;
  }

  add_filter('sga_ranking_before_title', 'sga_ranking_thumbnail_image', 10, 2);

  function sga_ranking_description($description, $id) {
   $post = get_post($id);
   $description = wp_trim_words(strip_shortcodes($post->post_content), 120);
   $html = '';

   if (isset($description)) {
     $html .= '<p class="sga-ranking__excerpt">' . $description . '</p>';
   }

   return $html;
  }

  add_filter('sga_ranking_after_title', 'sga_ranking_description', 10, 2);
}


// if (function_exists('sga_ranking_get_date')) {
//   $args = array(
//     'display_count'           => 10,
//     'period'                  => 30,
//     'post_type'               => 'post', 'event',
//     'exclude_post_type'       => '',
//     '`taxonomy_slug`__in'     => '',
//     '`taxonomy_slug`__not_in' => '',
//     'filter'                  => ''
//   );
// 
//   $ranking_data = sga_ranking_get_date($args);
// }

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
  if ($context === 'event' || $context === 'post' || $context === 'page') {
    $tags['moreads'] = true;
    $tags['ruby'] = true;
    $tags['rp'] = true;
    $tags['rt'] = true;
    // iframe
    $tags['iframe']=array(
      'class'=>array(),
      'src'=>array(),
      'data-layzr'=>array(),
      'data-src'=>array(),
      'width'=>array(),
      'height'=>array(),
      'frameborder'=>array(),
      'allow'=>array(),
      'allowfullscreen'=>array(),
      'scrolling'=>array(),
      'allowtransparency'=>array(),
    );
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

function get_the_genre_name($terms) {
  $length = count($terms);
  $target_genre  = ['restaurant', 'cafe', 'news', 'karaoke', '25stage', 'gengaten-tenjikai', 'feature', 'stamp-rally', 'amusement', 'fashion', 'theme-park', 'pop-up-store', 'only-shop', 'kuji', 'convenience-store'];
  $term_slug = [];
  $genre_name = '';

  for($i = 0; $i < $length; $i++) {
    // 親カテゴリがあるカテゴリを除外
    $term_slug[] .= $terms[$i]->slug;
  }

  $result = array_intersect($term_slug, $target_genre);
  $result = array_values($result);
  $result_length = count($result);

  if ($result_length > 1) {
    $genre_name = $result[0];
  } else {
    if (! empty($result[0])) {
      $genre_name = $result[0];
    }
  }

  return $genre_name;
}

function get_the_work_term_name($terms, $value = 'name') {
  $length = count($terms);
  $ignore_terms = ['cafe', 'news', 'collabo-period', 'event', 'karaoke', 'restaurant'];
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
      if ($value === 'slug') {
        $work_name = $terms[$i]->slug;
      } else {
        $work_name = $terms[$i]->name;
      }
    }
  }

  return $work_name;
}

function get_the_event_detail_name($post_id, $terms) {
  $tags = get_the_terms($post_id, 'event-tag');
  $target_event_genre  = ['popup-store', 'gengaten', 'fashion', 'konbini', 'stamp-rally', 'onlyshop', 'nazotoki', 'escape-game'];
  $len = count($target_event_genre);
  $term_slug = [];
  $event_name = '';

  foreach($tags as $tag) {
    $term_slug[] .= $tag->slug;
  }

  $result = array_intersect($term_slug, $target_event_genre);
  $result_length = count($result);

  if ($result_length > 1) {
    foreach($result as $genre) {
      switch($genre) {
        case $genre === $target_event_genre[0]:
          $event_name = $genre;
          break;

        case $genre === $target_event_genre[1]:
          $event_name = $genre;
          break;

        case $genre === $target_event_genre[2]:
          $event_name = $genre;
          break;

        case $genre === $target_event_genre[3]:
          $event_name = $genre;
          break;

        case $genre === $target_event_genre[4]:
          $event_name = $genre;
          break;

        case $genre === $target_event_genre[5]:
          $event_name = $genre;
          break;

        case $genre === $target_event_genre[6]:
          $event_name = $genre;
          break;

        case $genre === $target_event_genre[7]:
          $event_name = $genre;
          break;

        default:
          $event_name = '';
          break;
      }
    }
  } elseif ($result_length === 1) {
    $event_name = array_values($result);
  }

  foreach($tags as $tag) {
    if (is_string($event_name)) {
      if ($tag->slug === $event_name) {
        $event_name = $tag->name;
      }
    } else if (is_array($event_name)) {
      if ($tag->slug === $event_name[0]) {
        $event_name = $tag->name;
      }
    }
  }

  if (empty($event_name)) {
    $event_name = 'アニメ・漫画の期間限定イベント';
  }

  return $event_name;
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

// AMPだけ実行
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

    if (strpos($_SERVER['REQUEST_URI'], 'usamaru-cafe2018-winter') !== false || strpos($_SERVER['REQUEST_URI'], 'ojamajodoremi-20th-anniversary-cafe2019') !== false) {
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

function get_slug_by_path() {
  $url = $_SERVER['REQUEST_URI'];
  $path_arr = explode('/', $url);
  $path_count = count($path_arr);
  $cat_slug = '';

  if ($path_count >= 2) {
    if (array_values($path_arr) === $path_arr) {
      $cat_slug = $path_arr[$path_count - 2];
    }
  }

  return $cat_slug;
}

function page_nav_singular() {
  global $pages, $page, $numpages;
  // ページ分割されていなければ処理を抜ける
  if( $numpages == 1 ) {
    return;
  }

  // 現在何ページ目かを取得
  $paged = (get_query_var('page')) ? get_query_var('page') : 1;

  // パーマリンクがデフォルトかどうか調べる。それによってformatを返る必要がある
  if ( get_option('permalink_structure') == '' ) {
    $format = '&page=%#%';
  } else {
    $format = '/%#%/';
  }

  // paginate_linksでつかうパラメータを設定
  $arg = array(
    'base' => rtrim(get_permalink(),'/').'%_%',
    'format' =>$format,
    'total' => $numpages,
    'current' => $paged,
    'show_all' => true,
    'prev_text' => __('<i class="fa fa-chevron-left"></i>'),
    'next_text' => __('次のページ'),
  );
  // paginate_links( $arg )

  //最初と最後の記事では前後の記事へのリンクの片方が表示されないが、それを表示させるための処理
  $prev_tag = '';
  $next_tag = '';

  if ($paged === 1 ) {
    $prev_tag = '<div class="nav__page__partial__links__prev--disable">前</div>'.PHP_EOL;
  }
  if ($paged === $numpages) {
    $next_tag = PHP_EOL.'<div class="nav__page__partial__links__next--disable">次</div>';
  }
?>
  <div class="nav__page__partial">
    <div class="nav__page__partial__links">
      <?php echo $prev_tag . paginate_links( $arg ) .$next_tag; ?>
    </div>
    <div class="nav__page__partial__counter">
      <?php echo $paged ?><span> / <?php echo $numpages;?> ページ</span>
    </div>
  </div>
<?php
}

//ユーザー情報追加
add_action('show_user_profile', 'add_user_profile');
add_action('edit_user_profile', 'add_user_profile');
function add_user_profile($user) { ?>
<h3>役職</h3>
<table class="form-table">
<tr>
 <th>
 <label for="position">役職名</label>
 </th>
 <td>
 <input type="text" name="position" id="position" value="<?php echo esc_attr( get_the_author_meta( 'position', $user->ID ) ); ?>" class="regular-text" />
 <p><span class="description">例: ライター、WEBデザイナー、編集者など</p>
 </td>
</tr>
</table>
<?php }

//入力した値を保存する
add_action('personal_options_update', 'update_user_profile');
function update_user_profile($user_id) {
 if ( current_user_can('edit_user',$user_id) )
 update_user_meta($user_id, 'position', $_POST['position']);
}

// レビュー待ちの投稿がされた場合に管理者にメールを送信します。
function mail_for_pending( $new_status, $old_status, $post ) {
  // 投稿がレビュー待ち以外からレビュー待ちに変わった(新規の場合は$old_statusが'new'、$new_statusが'pending')
  if ( $old_status !== 'pending' && $new_status === 'pending' ) {
    // サイト名
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    // 投稿名
    $post_title = wp_specialchars_decode($post->post_title, ENT_QUOTES);

    // 送信先(管理者)
    $to = get_option('admin_email');
    // 件名
    $subject = "[{$blogname}] レビュー待ちの記事「{$post_title}」が送信されました";
    // 本文
    $message = "レビュー待ちの記事「{$post_title}」が投稿されました。確認をお願いします。\r\n";
    $message .= "\r\n";
    $message .= "編集および公開: \r\n";
    $message .= wp_specialchars_decode(get_edit_post_link( $post->ID ), ENT_QUOTES) . "\r\n";

    // メールを送信
    $r = wp_mail($to, $subject, $message);
  }
}
add_action( 'transition_post_status', 'mail_for_pending', 10, 3 );

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
