import Raven from 'raven-js';
import Layzr from 'layzr.js';
// import {TweenMax, TimelineLite} from "gsap/TweenMax";
const Flickity = require('flickity-fade');;

Raven.config('https://c64bcab93be44548afdc13db988fc2ac@sentry.io/1195109').install();

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
const body = document.getElementsByTagName('body'),
    wrap = document.getElementById('container'),
    selectCategory = $(wrap).find('.eo__event_categories select'),
    header = $(wrap).find('.header'),
    modal = $(wrap).find('.js__modal--mail'),
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
    initPos = 0;

modal.on('click', function(e) {
  let target = $(this).attr('href'),
      targetModal = $(target),
      closeButton = targetModal.find('.js__modal-close');

  if (targetModal.length) {
    targetModal.addClass('is-show');
  }

  if (closeButton.length) {
    closeButton.on('click', function(e) {
      targetModal.removeClass('is-show');
      e.preventDefault();
    });
  }

  e.preventDefault();
});

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

// Slickの置き換え
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

      $(sliderItem).on('click', function() {
        const index = $(this).index();
        $(sliderItem).removeClass(slideCurrentClass);
        flktyMain.stopPlayer();
        sliderItem[index].classList.add(slideCurrentClass);
        flktyMain.select(index);
        flktyMain.playPlayer();
      });

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
      $(sliderItem).removeClass(slideCurrentClass);
      sliderItem[index].classList.add(slideCurrentClass);
    }),
  },
});
