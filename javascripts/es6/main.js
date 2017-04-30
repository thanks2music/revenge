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

console.log(0);
