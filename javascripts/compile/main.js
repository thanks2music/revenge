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
  var theContent = $('#main .article');
  var eventDetail = $(body).find('.eventorganiser-event-meta');

  $(theContent).append(eventDetail);
}