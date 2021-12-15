<?php global $is_sp, $is_pc ?>
<?php // Google Adsense ?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<?php if ($is_sp && is_web()) { ?>
  <?php // Geniee Tag for Google Ad Manager ?>
  <script>
    window.gnshbrequest = window.gnshbrequest || {cmd:[]};
      gnshbrequest.cmd.push(function(){
        gnshbrequest.registerPassback("1511018");
        gnshbrequest.forceInternalRequest();
    });
  </script>
  <script async src="https://cpt.geniee.jp/hb/v1/213660/461/wrapper.min.js"></script>
<?php } ?>
