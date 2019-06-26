<?php
  //ヘッダーお知らせ欄
  if(get_option('header_info_text')):
?>
  <div class="header-info">
    <a href="<?php echo get_option('header_info_url') ?>">
      <?php echo get_option('header_info_text'); ?>
    </a>
  </div>
<?php 
  endif;
?>