<?php
  $app_point = ['記事のお気に入りなど<br>アプリ専用機能も！', '好きな作品を登録して<br>自分だけの記事一覧！', 'アプリならジャンル別で<br>読みやすい！', '気になる記事に<br>コメントしてみよう！'];
  $rand_keys = array_rand($app_point, 1);
?>
<div class="app__smart__dl">
  <a class="app__smart__dl__anchor app__official__banner__anchor" href="/app-download/">
    <div class="app__smart__dl__image">
      <?php if (! empty($_GET['amp']) && $_GET['amp'] === '1') { ?>
      <?php } else { ?>
        <img src="/wp-content/uploads/dummy.png" data-src="/wp-content/uploads/collabo-cafe-app-icon.png" alt="コラボカフェ - アニメ・漫画の期間限定イベント情報アプリ" width="44" height="44">
      <?php } ?>
    </div>
    <div class="app__smart__dl__text">
      <p class="app__smart__dl__title">コラボカフェアプリ</p>
      <p class="app__smart__dl__description"><?php echo $app_point[$rand_keys]; ?></p>
    </div>
    <div class="app__smart__dl__button">無料ダウンロード</div>
  </a>
</div>
