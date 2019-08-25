<?php
if (! empty($_GET['amp'])) {
  if ($_GET['amp'] === '1') { ?>
  <amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-KM5475F&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
  <?php }
} else if (get_option('other_options_ga')) { ?>
<?php // GTM No Script ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WT89942"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php } ?>
