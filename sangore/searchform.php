<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
  <div>
    <input type="search" id="s" class="searchform__input" name="s" value="" placeholder="検索" />
    <button type="submit" id="searchsubmit" class="searchform__submit"><?php fa_tag("search","search",false) ?></button>
  </div>
</form>