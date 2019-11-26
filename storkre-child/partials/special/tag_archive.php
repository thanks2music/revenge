<?php
  $term_object = get_queried_object();
  $viral_name = 'viral__layout--';

  if (! empty($term_object->slug)) {
    $viral_name .= $term_object->slug;
  }
?>
<div class="viral__layout <?php echo $viral_name; ?>">
  <header class="viral__layout__keyvisual">
    <div class="viral__layout__content">
      <h2 class="viral__layout__title"><?php echo $term_object->name; ?></h2>
      <p class="viral__layout__description"><?php echo $term_object->description; ?></p>
    </div>
  </header>
</div>
