'use strict';

// Global Object
var _ref = [window, document, window.location, navigator.userAgent],
    win = _ref[0],
    doc = _ref[1],
    uri = _ref[2],
    ua = _ref[3];

var is_sp = function is_sp() {
  if (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
    return true;
  } else if (ua.indexOf('Mobile') > 0) {
    return true;
  } else {
    return false;
  }
};

var is_tab = function is_tab() {
  if (ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') === -1) {
    return true;
  } else {
    return false;
  }
};

var is_pc = function is_pc() {
  if (!is_sp() && !is_tab()) {
    return true;
  } else {
    return false;
  }
};

// Common
var body = doc.getElementsByTagName('body');

// for Single
if (body[0].className.indexOf('single') > -1) {
  var main = $(body).find('#main');
  var theContent = main.find('.article');
  var eventDetail = $(body).find('.eventorganiser-event-meta');

  // 記事詳細のMap部分を切り抜いて記事下部に追加
  $(theContent).append(eventDetail);

  // スムーススクロール
  main.find('.smooth-scroll').on('click', function (e) {
    var speed, href, target, position;
    speed = 300;
    href = $(this).attr('href');
    target = $(href == '#' || href == '' ? 'html' : href);

    if (target.length) {
      position = target.offset().top;
      $('body, html').animate({ scrollTop: position }, speed, 'swing');
    }

    return false;
  });
}