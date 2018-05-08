import Raven from 'raven-js';
Raven.config('https://c64bcab93be44548afdc13db988fc2ac@sentry.io/1195109').install();
import Layzr from 'layzr.js';

const [win, doc, uri, ua] = [window, document, window.location, navigator.userAgent];
const is_sp = () => {
  if (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
    return true;
  } else if (ua.indexOf('Mobile') > 0) {
    return true;
  } else {
    return false;
  }
};

const is_tab = () => {
  if (ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') === -1) {
    return true;
  } else {
    return false;
  }
};

const is_pc = () => {
  if (! is_sp() && ! is_tab()) {
    return true;
  } else {
    return false;
  }
};

// Common
const body = document.getElementsByTagName('body'),
    wrap = document.getElementById('container'),
    selectCategory = $(wrap).find('.eo__event_categories select'),
    header = $(wrap).find('.header'),
    des = $(wrap).find('.site_description');
const cloneHeader = header.clone(true);
// @description img data-srcがあり、class="lazy" があるimg要素は遅延読み込みさせる
const lazyLoadInstance = Layzr({
  normal: 'data-src',
  threshold: 5
});
// lazyLoad
lazyLoadInstance.on('src:before', (element) => {
  element.classList.add('is-loaded');
});
lazyLoadInstance.update().check().handlers(true);

// for Design
let customHeader = $(wrap).find('#custom_header .wrap'),
    initPos = 0,
    slickElement = $(wrap).find('.slickcar');

$(window).on('scroll', (e) => {
  setTimeout(() => {
    const currentPos = $(window).scrollTop();

    if (cloneHeader.hasClass('fixed')) {
      if (currentPos < 200) {
        cloneHeader.fadeOut(300).removeClass('fixed action').remove();
      }
    } else if (initPos > currentPos && currentPos >= 200) {
      cloneHeader.appendTo(header).addClass('fixed');
      cloneHeader.delay(300).queue(() => {
        cloneHeader.addClass('action');
      });
    }

    initPos = currentPos;
  }, 200);
});

selectCategory.on('change', function() {
  const categoryPath = $(this).val(),
        redirectPath = '/events/category/' + categoryPath;

  setTimeout(function() {
    window.location.href = redirectPath;
  }, 100);
});

document.addEventListener('DOMContentLoaded', () => {
  $(body).addClass('loaded');
});

// for Single
if (body[0].className.indexOf('single') > -1) {
  const photoSwipe = $(body).find('.pswp');
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
      const headerHeight = $(body).find("#inner-header").height();
      position = target.offset().top;
      position = position - headerHeight;
      $('body, html').animate({scrollTop: position}, speed, 'swing');
    }

    return false;
  });

  if (photoSwipe === null || photoSwipe === undefined) {
    $.get('/wp-content/themes/collabo-child/partials/photoswipe.php', function(data) {
      $(wrap).after(data);
    });
  }
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
