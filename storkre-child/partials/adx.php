<?php global $is_sp, $is_pc ?>
<?php // Google Adsense ?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<?php if ($is_sp && is_web()) { ?>
  <?php // GMO YDN Tag ?>
  <script src="//cdn.gmossp-sp.jp/ads/loader.js?space_id=g908845" charset="utf-8" language="JavaScript"></script>
  <script language='javascript'>
      gmossp_forsp.ad('g908845');
  </script>
  <script async src="https://l.logly.co.jp/lift_widget.js?adspot_id=4294347"></script>
<?php } else if ($is_pc && is_web()) { ?>
  <script async src="https://l.logly.co.jp/lift_widget.js?adspot_id=4294348"></script>
<?php } ?>
