<?php global $is_sp, $is_pc, $post ?>
<?php // Google Adsense ?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<?php if (is_web()) { ?>
  <script src="https://flux-cdn.com/client/1000300/collabo-cafe_01514.min.js" async></script>
<?php } ?>

<?php if ($is_sp && is_web()) { ?>
  <script>
    window.gnshbrequest = window.gnshbrequest || {cmd:[]};
      gnshbrequest.cmd.push(function(){
        gnshbrequest.registerPassback("1511018");
        gnshbrequest.forceInternalRequest();
    });
  </script>
<script async src="https://cpt.geniee.jp/hb/v1/213660/461/wrapper.min.js"></script>
<script src="https://cpt.geniee.jp/hb/v1/213660/461/instbody.min.js"></script>
<?php } ?>
