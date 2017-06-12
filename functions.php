<?php

// 子テーマのstyle.cssを後から読み込む
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  global $dir;
  $time_stamp = time();
  wp_enqueue_style('style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style('webfont-amatic', 'https://fonts.googleapis.com/css?family=Amatic+SC');

  wp_enqueue_style('child-style',
    $dir['theme'] . '/stylesheets/main.css?' . $time_stamp,
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
  wp_enqueue_script('app', $dir['theme'] . '/dist/scripts/app.js?' . $time_stamp);
}


// MOREタグの下に広告を表示
add_filter('the_content', 'adMoreReplace');
function adMoreReplace($contentData) {
  global $is_sp;
  $adTags = '';

  // SP
  if ($is_sp) {
$adTags = <<< EOF

<div class="add more">
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- CC - 記事の途中 -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="4994583614"
       data-ad-format="auto"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;
    // PC
  } else {
$adTags = <<< EOF

<div class="add more">
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- CC - PC記事の途中 -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-7307810455044245"
       data-ad-slot="6789910818"
       data-ad-format="auto"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

EOF;
  }
  $contentData = preg_replace('/<p><span id="more-([0-9]+?)"><\/span>(.*?)<\/p>/i', $adTags, $contentData);
  $contentData = str_replace('<p></p>', '', $contentData);
  $contentData = str_replace('<p><br />', '<p>', $contentData);

  return $contentData;
}

// パンくず
if (!function_exists('breadcrumb')) {
	function breadcrumb($divOption = array("id" => "breadcrumb", "class" => "breadcrumb inner wrap cf")){
    global $post;
    $str ='';
    if(! get_option('side_options_pannavi')){
      if (! is_home() && ! is_front_page() && ! is_admin() ){
          $tagAttribute = '';
          foreach($divOption as $attrName => $attrValue){
              $tagAttribute .= sprintf(' %s="%s"', $attrName, $attrValue);
          }
          $str.= '<div'. $tagAttribute .'>';
          $str.= '<ul>';
          $str.= '<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><a href="'. home_url() .'/" itemprop="url"><i class="fa fa-home"></i><span itemprop="title"> HOME</span></a></li>';
   
          if (is_category()) {
              $cat = get_queried_object();

              if ($cat->parent != 0){
                $ancestors = array_reverse(get_ancestors($cat->cat_ID, 'category' ));
                foreach($ancestors as $ancestor){
                  $str.='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($ancestor) .'" itemprop="url"><span itemprop="title">'. get_cat_name($ancestor) .'</span></a></li>';
                }
              }

              $str.='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $cat -> name . '</span></li>';
          } elseif (is_single()) {
              $post_type = get_post_type();
              $taxonomy_name = 'category';
              if ($post_type === 'event') {
                $taxonomy_name = 'event-category';
              }

              $categories = get_the_terms($post->ID, $taxonomy_name);
              $cat_len = count($categories);

              if ($cat_len > 0) {
                $cat = $categories[1];
                // TODO 後で文字列以外の方法で
                // for ($i= 0; $i < $cat_len; $i++) {
                //   if ($cat[$i]->slug !== '') {
                //   }
                // }
              } else {
                $cat = $categories[0];
              }

              if ($cat->parent != 0) {
                  $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, $taxonomy_name));
                  foreach($ancestors as $ancestor){
                      $str.='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($ancestor).'" itemprop="url"><span itemprop="title">'. get_cat_name($ancestor). '</span></a></li>';
                  }
              }

              // Category
              if ($post_type === 'post') {
                $str.='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat -> term_id). '" itemprop="url"><span itemprop="title">'. $cat-> cat_name . '</span></a></li>';
                // Taxonomy
              } else {
                $str.='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><a href="'. get_term_link($cat->term_taxonomy_id, $taxonomy_name). '" itemprop="url"><span itemprop="title">'. $cat->name . '</span></a></li>';
              }
              $str.= '<li>'. $post -> post_title .'</li>';
          } elseif(is_page()){
              if($post -> post_parent != 0 ){
                  $ancestors = array_reverse(get_post_ancestors( $post->ID ));
                  foreach($ancestors as $ancestor){
                      $str.='<li itemscope itemtype="//data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($ancestor).'" itemprop="url"><span itemprop="title">'. get_the_title($ancestor) .'</span></a></li>';
                  }
              }
              $str.= '<li>'. $post -> post_title .'</li>';
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
