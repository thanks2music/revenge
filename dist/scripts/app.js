"use strict";var _ref=[window,document,window.location,navigator.userAgent],win=_ref[0],doc=_ref[1],uri=_ref[2],ua=_ref[3],is_sp=function(){return ua.indexOf("iPhone")>0||ua.indexOf("iPod")>0||ua.indexOf("Android")>0&&ua.indexOf("Mobile")>0||ua.indexOf("Mobile")>0},is_tab=function(){return ua.indexOf("iPad")>0||ua.indexOf("Android")>0&&-1===ua.indexOf("Mobile")},is_pc=function(){return!is_sp()&&!is_tab()},body=doc.getElementsByTagName("body");if(body[0].className.indexOf("single")>-1){var theContent=$("#main .article"),eventDetail=$(body).find(".eventorganiser-event-meta");$(theContent).append(eventDetail)}