!function(e){function n(o){if(t[o])return t[o].exports;var i=t[o]={i:o,l:!1,exports:{}};return e[o].call(i.exports,i,i.exports,n),i.l=!0,i.exports}var t={};n.m=e,n.c=t,n.i=function(e){return e},n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},n.p="",n(n.s=0)}([function(e,n,t){"use strict";window,document,window.location,navigator.userAgent;var o=document.getElementsByTagName("body"),i=document.getElementById("container"),r=$(i).find(".eo__event_categories select"),a=$(i).find(".header"),s=($(i).find(".site_description"),a.clone(!0)),d=($(i).find("#custom_header .wrap"),$(i).find(".slickcar"));if($(window).on("scroll",function(){var e=$(this).scrollTop();setTimeout(function(){e>100&&!s.hasClass("fixed")&&(s.appendTo(a).addClass("fixed"),s.delay(1e3).queue(function(){$(this).addClass("action")})),e<100&&s.removeClass("fixed action").fadeOut(300).remove()},100)}),r.on("change",function(){var e="/events/category/"+$(this).val();setTimeout(function(){window.location.href=e},100)}),document.addEventListener("DOMContentLoaded",function(){$(o).addClass("loaded")}),o[0].className.indexOf("single")>-1){var c=$(o).find("#main"),l=c.find(".hentry"),u=l.find(".eventorganiser-event-meta");$(l).append(u),u.addClass("action"),c.find(".smooth-scroll").on("click",function(e){var n,t,o;return 300,n=$(this).attr("href"),(t=$("#"==n||""==n?"html":n)).length&&(o=t.offset().top,$("body, html").animate({scrollTop:o},300,"swing")),!1})}d.length&&d.slick({centerMode:!0,dots:!0,autoplay:!0,autoplaySpeed:3e3,speed:260,centerPadding:"90px",slidesToShow:4,responsive:[{breakpoint:1160,settings:{arrows:!1,centerMode:!0,centerPadding:"40px",slidesToShow:4}},{breakpoint:768,settings:{arrows:!1,centerMode:!0,centerPadding:"40px",slidesToShow:3}},{breakpoint:480,settings:{arrows:!1,centerMode:!0,centerPadding:"25px",slidesToShow:1}}]})}]);