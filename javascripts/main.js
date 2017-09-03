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
let body = document.getElementsByTagName('body'),
    wrap = document.getElementById('container');
// for Design
let customHeader = $(wrap).find('#custom_header .wrap'),
    slickElement = $(wrap).find('.slickcar');

document.addEventListener('DOMContentLoaded', () => {
  $(body).addClass('loaded');
});


// for Single
if (body[0].className.indexOf('single') > -1) {
  let main = $(body).find('#main');
  let theContent = main.find('.hentry');
  let eventDetail = theContent.find('.eventorganiser-event-meta');

  // 記事詳細のMap部分を切り抜いて記事下部に追加
  $(theContent).append(eventDetail);
  eventDetail.addClass('action');

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

// トップページでSlickがあったら
if (slickElement.length) {
  slickElement.slick({
    centerMode: true,
    dots: true,
    autoplay: true,
    autoplaySpeed: 3000,
    speed: 260,
    centerPadding: '90px',
    slidesToShow: 4,
    responsive: [{
      breakpoint: 1160,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 4
      }
    },
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '25px',
        slidesToShow: 1
      }
    }]
  });
}
