  // Global Object
  let [win, doc, uri, ua] = [window, document, window.location, navigator.userAgent];
  let is_sp = () => {
    if (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
      return true;
    } else if (ua.indexOf('Mobile') > 0) {
      return true;
    } else {
      return false;
    }
  };

  let is_tab = () => {
    if (ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') === -1) {
      return true;
    } else {
      return false;
    }
};

let is_pc = () => {
  if (! is_sp() && ! is_tab()) {
    return true;
  } else {
    return false;
  }
};

// Common
let body = doc.getElementsByTagName('body');

// for Single
if (body[0].className.indexOf('single') > -1) {
  let main = $(body).find('#main');
  let theContent = main.find('.article');
  let eventDetail = $(body).find('.eventorganiser-event-meta');

  // 記事詳細のMap部分を切り抜いて記事下部に追加
  $(theContent).append(eventDetail);

  // スムーススクロール
  main.find('.smooth-scroll').on('click', function(e) {
    var speed, href, target, position;
    speed = 300;
    href = $(this).attr('href');
    target = $(href == '#' || href == '' ? 'html' : href);

    if (target.length) {
      position = target.offset().top;
      $('body, html').animate({scrollTop: position}, speed, 'swing');
    }

    return false;
  });
}
