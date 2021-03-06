// import Raven from 'raven-js';
import Layzr from 'layzr.js/dist/layzr.min.js';
import Cookies from 'js-cookie';
const Flickity = require('flickity-fade');

// Raven.config('https://c64bcab93be44548afdc13db988fc2ac@sentry.io/1195109').install();

const ua = navigator.userAgent;
const is_sp = () => {
  if (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
    return true;
  } else if (ua.indexOf('Mobile') > 0) {
    return true;
  } else {
    return false;
  }
};

// Common
const body            = document.getElementsByTagName('body'),
      wrap            = document.getElementById('container'),
      selectCategory  = $(wrap).find('.eo__event_categories select'),
      closeWorkDetail = $(wrap).find('#js__close__work__detail'),
      header          = $(wrap).find('.header'),
      youtube         = $(wrap).find('.video__responsive'),
      params          = window.location.search,
      des             = $(wrap).find('.site_description');
const cloneHeader = header.clone(true);

// for Design
let customHeader = $(wrap).find('#custom_header .wrap'),
    initPos = 0;

function setAppUrl(dom) {
  const url = dom.attr('href');

  if (ua.indexOf('Android') > 0 && url.indexOf('google') > -1) {
    dom.attr('href', 'https://play.google.com/store/apps/details?id=com.collabo_cafe.app');
  } else if (url.indexOf('apple') > -1) {
    dom.attr('href', 'https://apps.apple.com/jp/app/id1481548251/');
  }
}

function is_app() {
  return (params.indexOf('layout=app') > -1 ? true : false);
}

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

if (closeWorkDetail.length) {
  closeWorkDetail.on('click', (e) => {
    const parentElement = $(e.currentTarget).parents('.work__detail'),
          iconElement = parentElement.find('.fa'),
          toggleElement = parentElement.find('.work__detail__inner');

    // if (! Cookies.get('closeWork')) {
    //   Cookies.set('closeWork', 'true', { expires: 14, path: '/' });
    // }

    if (iconElement.hasClass('fa-plus-circle')) {
      iconElement.removeClass('fa-plus-circle').addClass('fa-minus-circle');
    } else {
      iconElement.removeClass('fa-minus-circle').addClass('fa-plus-circle');
    }
    toggleElement.slideToggle(300, () => {
      parentElement.toggleClass('work__detail--toggle');
    });
  });
}

selectCategory.on('change', function() {
  const categoryPath = $(this).val(),
        redirectPath = '/events/category/' + categoryPath;

  setTimeout(function() {
    window.location.href = redirectPath;
  }, 100);
});

function youtubeImgReplace(element) {
  let youtubeImgUrl = 'https://i.ytimg.com/vi/';
  let id = element.src.match(/[\/?=]([a-zA-Z0-9_-]{11})[&\?]?/)[1];
  let imgUrl = youtubeImgUrl + id + '/hqdefault.jpg';

  let image = new Image();
  image.src = element.src;
  image.onload = function(){
    let imageWidth = image.naturalWidth;
    let imageHeight = image.naturalHeight;

    if (imageWidth === 120) { // YouTubeのサムネイル画像が404時の時のサイズ
      $(element).attr('src', imgUrl);
    }
  };
}

// Load後
document.addEventListener('DOMContentLoaded', () => {
  $(body).addClass('loaded');

  // YouTubeをサムネイル表示に変更する
  youtube.each(function () {
    let iframe = $(this).find('iframe');
    let youtubeImgUrl = 'https://i.ytimg.com/vi/';
    let url = iframe.attr('data-youtube');
    let id = url.match(/[\/?=]([a-zA-Z0-9_-]{11})[&\?]?/)[1];
    let imgUrl = youtubeImgUrl + id + '/maxresdefault.jpg';
    iframe.before('<img data-src="' +imgUrl+ '" src="/wp-content/uploads/dummy.png" width="1280" height="720" alt="" />').remove();

    $(this).on('click', function() {
      $(this).html('<iframe src="https://www.youtube.com/embed/'+id+'" loading="lazy" width="728" height="410" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
      $(this).find('img').remove();
    });
  });

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

  lazyLoadInstance.on('src:after', (element) => {
    if (element.offsetParent.className === 'video__responsive') {
      youtubeImgReplace(element);
    }
  });
});

// for Single
if (body[0].className.indexOf('single') > -1) {
  const photoSwipe = $(body).find('.pswp');
  let main = $(body).find('#main');
  let theContent = main.find('.hentry');

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

if (body[0].className.indexOf('app') > -1) {
  const questions = $(body).find('.app__faq__questions__list__question');

  if (questions.length) {
    questions.on('click', function(e) {
      $(this).toggleClass('app__faq__questions__list--question');
      $(this).next('dd').slideToggle(200);
    });
  }
}

// トップページまたはトップページの仮想ページのみ
if (window.location.pathname === '/' || window.location.pathname.indexOf('/page/') > -1) {
  if (window.location.search.indexOf('preview') === -1) {
    let sliderMain = document.getElementById('header__slider__ul'),
        sliderNav  = document.getElementById('header__slider__nav'),
        sliderItem = sliderNav.querySelectorAll('.header__slider__nav__item'),
        slideCurrentClass = 'header__slider__nav__progress--current';

    let flickityFade = false;

    // PCの場合
    if (! is_sp()) {
      flickityFade = true;
    }

    let flktyMain = new Flickity(sliderMain, {
      fade: flickityFade,
      freeScroll: false,
      contain: true,
      imagesLoaded: true,
      autoPlay: 5000,
      pageDots: false,
      wrapAround: true,
      on: {
        ready: (() => {
          sliderMain.previousElementSibling.classList.add('header__slider__dummy--is-hide');
          sliderMain.classList.add('header__slider__ul--is-active');
          sliderItem[0].classList.add(slideCurrentClass);
          let slideCurrentElem = sliderNav.querySelector(`.${slideCurrentClass}`);

          if (is_sp()) {
            $(sliderItem).on('click', function() {
              const index = $(this).index();
              $(sliderItem).removeClass(slideCurrentClass);
              flktyMain.stopPlayer();
              sliderItem[index].classList.add(slideCurrentClass);
              flktyMain.select(index);
              flktyMain.playPlayer();
            });
          } else {
            $(sliderItem).on('click', function() {
              const index = $(this).index();
              flktyMain.select(index);
            });
          }

          if (! is_sp()) {
            $(sliderItem, slideCurrentElem).on({
              'mouseenter' : function(e) {
                flktyMain.pausePlayer();
              },
              'mouseleave' : function(e) {
                flktyMain.playPlayer();
              }
            });
          }
        }),
        change: ((index) => {
          if (is_sp()) {
            flktyMain.stopPlayer();
            $(sliderItem).removeClass(slideCurrentClass);
            sliderItem[index].classList.add(slideCurrentClass);
            flktyMain.select(index);
            flktyMain.playPlayer();
          } else {
            $(sliderItem).removeClass(slideCurrentClass);
            sliderItem[index].classList.add(slideCurrentClass);
          }
        }),
      },
    });
  }
}
