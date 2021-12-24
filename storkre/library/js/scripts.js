/////////////////////////////////
//Windowsサイズを取得
/////////////////////////////////
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
var viewport = updateViewportDimensions();



/////////////////////////////////
// 画面のサイズ変更が完了した時にjqueryを動かす
/////////////////////////////////
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();
var timeToWaitForLast = 100;


function loadGravatars() {
  viewport = updateViewportDimensions();
  if (viewport.width >= 768) {
  jQuery('.comment img[data-gravatar]').each(function(){
    jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
  });
	}
}


/////////////////////////////////
// target Link内に画像がはいっている場合にクラスを追加
/////////////////////////////////
jQuery(function($){
$("a:has(img)").addClass("no-icon");
});


/////////////////////////////////
// ページトップへ戻るボタン
/////////////////////////////////
jQuery(document).ready(function($) {
$(function() {
    var showFlag = false;
    var topBtn = $('#page-top');
    topBtn.css('bottom', '-100px');
    var showFlag = false;
    var clickFlag = false;
    var articleNavigation = $('.cc-jump-section');

    //スクロールが400に達したらボタン表示
    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            if (showFlag == false) {
                showFlag = true;
                topBtn.stop().animate({'bottom' : '150px'}, 200); 
            }
        } else {
            if (showFlag) {
                showFlag = false;
                topBtn.stop().animate({'bottom' : '-100px'}, 200); 
            }
        }
    });

    //スクロールしてトップ
    topBtn.click(function (e) {
      if (clickFlag && articleNavigation[0]) {
        var headerHeight = $("#inner-header").height();
        var articlePos = articleNavigation.offset().top - headerHeight;
        $('body,html').animate({
          scrollTop: articlePos
        }, 500);
      } else {
        $('body,html').animate({
          scrollTop: 0
        }, 500);
      }

      clickFlag = true;
      e.preventDefault;
    });
});
  loadGravatars();
});
