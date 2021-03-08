<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title(''); ?></title>
    <?php get_template_part('head'); ?>
  </head>
  <body>
    <?php get_template_part('partials/meta/gtm'); ?>
    <script>
      var ua = window.navigator.userAgent;
      var url = '';

      if (ua.indexOf('iPhone') > 0 && ua.indexOf('Mobile') > 0) {
        var url = 'https://apps.apple.com/jp/app/id1481548251/';
      } else if (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
        var url = 'https://play.google.com/store/apps/details?id=com.collabo_cafe.app';
      } else if (ua.indexOf('iPad') > 0) {
        var url = 'https://apps.apple.com/jp/app/id1481548251/';
      } else if (ua.indexOf('iPad') > -1 || ua.indexOf('macintosh') > -1 && 'ontouchend' in document) {
        var url = 'https://apps.apple.com/jp/app/id1481548251/';
      } else if (ua.indexOf('Android') > 0) {
        var url = 'https://play.google.com/store/apps/details?id=com.collabo_cafe.app';
      } else {
        var url = 'https://apps.apple.com/jp/app/id1481548251/';
      }

      document.addEventListener('DOMContentLoaded', function() {
        window.location = url;
      });
    </script>
  </body>
</html>
