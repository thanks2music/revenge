<?php
/******************************
 * カスタマイザーで登録されたスタイルの設定を反映させる
 ********************************/
function sng_customizer_css()
{
  $link_c = get_theme_mod('link_color', '#4f96f6');
  $main_c = get_theme_mod('main_color', '#6bb6ff');
  $pastel_c = get_theme_mod('pastel_color', '#c8e4ff');
  $accent_c = get_theme_mod('accent_color', '#ffb36b');
  $header_bc = get_theme_mod('header_bc', '#58a9ef');
  $header_c = get_theme_mod('header_c', '#FFF');
  $header_menu_c = get_theme_mod('header_menu_c', '#FFF');
  $wid_c = get_theme_mod('wid_title_c', '#6bb6ff');
  $wid_bc = get_theme_mod('wid_title_bc', '#c8e4ff');
  $footer_c = get_theme_mod('sng_footer_c', '#3c3c3c');
  $footer_bc = get_theme_mod('sng_footer_bc', '#e0e4eb');
  $body_bc = get_theme_mod('background_color');
  //トップへ戻るボタン
  $totop_bc = get_theme_mod('to_top_color', '#5ba9f7');
  //お知らせ欄
  $info_text = get_theme_mod('header_info_c', '#FFF');
  $info_bc1 = get_theme_mod('header_info_c1', '#738bff');
  $info_bc2 = get_theme_mod('header_info_c2', '#85e3ec');
  //モバイルフッター固定メニュー
  $footer_fixed_bc = get_theme_mod('footer_fixed_bc', '#FFF');
  $footer_fixed_c = get_theme_mod('footer_fixed_c', '#a2a7ab');
  $footer_fixed_actc = get_theme_mod('footer_fixed_actc', '#6bb6ff');
  //フォントサイズ
  $mb_size = get_option('mb_font_size') ? get_option('mb_font_size') : '100';
  $tb_size = get_option('tb_font_size') ? get_option('tb_font_size') : '107';
  $pc_size = get_option('pc_font_size') ? get_option('pc_font_size') : '107';
  //タブ色
  $tab_bc = get_theme_mod('tab_background_color', '#FFF');
  $tab_c = get_theme_mod('tab_text_color', '#a7a7a7');
  $tab_active_bc1 = get_theme_mod('tab_active_color1', '#bdb9ff');
  $tab_active_bc2 = get_theme_mod('tab_active_color2', '#67b8ff');
  ?>
<style>
a {color: <?php echo $link_c; ?>;}
.main-c, .has-sango-main-color {color: <?php echo $main_c; ?>;}
.main-bc, .has-sango-main-background-color {background-color: <?php echo $main_c; ?>;}
.main-bdr, #inner-content .main-bdr {border-color:  <?php echo $main_c; ?>;}
.pastel-c, .has-sango-pastel-color {color: <?php echo $pastel_c; ?>; }
.pastel-bc, .has-sango-pastel-background-color, #inner-content .pastel-bc {background-color: <?php echo $pastel_c; ?>;}
.accent-c, .has-sango-accent-color {color: <?php echo $accent_c; ?>;}
.accent-bc, .has-sango-accent-background-color {background-color: <?php echo $accent_c; ?>;}
.header, #footer-menu, .drawer__title {background-color: <?php echo $header_bc; ?>;}
#logo a {color: <?php echo $header_c; ?>;}
.desktop-nav li a , .mobile-nav li a, #footer-menu a ,.copyright, #drawer__open, .header-search__open, .drawer__title {color: <?php echo $header_menu_c; ?>;}
.drawer__title .close span, .drawer__title .close span:before {background: <?php echo $header_menu_c; ?>;}
.desktop-nav li:after {background: <?php echo $header_menu_c; ?>;}
.mobile-nav .current-menu-item {border-bottom-color: <?php echo $header_menu_c; ?>;}
.widgettitle {color: <?php echo $wid_c; ?>;background-color:<?php echo $wid_bc; ?>;}
.footer {background-color: <?php echo $footer_bc; ?>;}
.footer, .footer a, .footer .widget ul li a {color: <?php echo $footer_c; ?>;}
<?php if ($body_bc): ?>.body_bc {background-color: #<?php echo $body_bc; ?>;}<?php endif;?>
#toc_container .toc_title, .entry-content .ez-toc-title-container, #footer_menu .raised, .pagination a, .pagination span, #reply-title:before , .entry-content blockquote:before ,.main-c-before li:before ,.main-c-b:before{color: <?php echo $main_c; ?>;}
#searchsubmit, #toc_container .toc_title:before, .ez-toc-title-container:before, .cat-name, .pre_tag > span, .pagination .current, #submit ,.withtag_list > span,.main-bc-before li:before {background-color: <?php echo $main_c; ?>;}
#toc_container, #ez-toc-container, h3 ,.li-mainbdr ul,.li-mainbdr ol {border-color: <?php echo $main_c; ?>;}
.search-title i ,.acc-bc-before li:before {background: <?php echo $accent_c; ?>;}
.li-accentbdr ul, .li-accentbdr ol {border-color: <?php echo $accent_c; ?>;}
.pagination a:hover ,.li-pastelbc ul, .li-pastelbc ol {background: <?php echo $pastel_c; ?>;}
body {font-size: <?php echo $mb_size; ?>%;}
@media only screen and (min-width: 481px) {
body {font-size: <?php echo $tb_size; ?>%;}
}
@media only screen and (min-width: 1030px) {
body {font-size: <?php echo $pc_size; ?>%;}
}
.totop {background: <?php echo $totop_bc; ?>;}
.header-info a {color: <?php echo $info_text; ?>; background: linear-gradient(95deg,<?php echo $info_bc1; ?>,<?php echo $info_bc2; ?>);}
.fixed-menu ul {background: <?php echo $footer_fixed_bc; ?>;}
.fixed-menu a {color: <?php echo $footer_fixed_c; ?>;}
.fixed-menu .current-menu-item a , .fixed-menu ul li a.active {color: <?php echo $footer_fixed_actc; ?>;}
.post-tab {background: <?php echo $tab_bc; ?>;} .post-tab>div {color: <?php echo $tab_c; ?>} .post-tab > div.tab-active{background: linear-gradient(45deg,<?php echo $tab_active_bc1; ?>,<?php echo $tab_active_bc2; ?>)}
</style>
<?php
}
add_action('wp_head', 'sng_customizer_css', 101);