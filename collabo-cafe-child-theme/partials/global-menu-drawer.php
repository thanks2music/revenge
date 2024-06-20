<div class="drawer">
  <input type="checkbox" class="drawer__form--hidden" id="drawer__input">
  <label class="drawer__open" for="drawer__input">
    <i class="fa fa-bars"></i>
  </label>
  <label class="drawer__close-cover" for="drawer__input"></label>
  <div class="drawer__content">
    <div class="drawer__title dfont">
      MENU
      <label class="drawer__content__close" for="drawer__input"><span></span></label>
    </div>

    <div class="drawer__content__nav">
      <?php dynamic_sidebar('widget_nav_drawer'); ?>
    </div>
  </div>
</div>

