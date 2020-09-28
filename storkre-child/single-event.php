<?php global $amp_flag;
  $post_type = get_post_type();

  if (! empty($_GET['amp'])) {
    if (is_single() && $_GET['amp'] === '1') {
      $amp_flag = true;
    }
  }

  if ($amp_flag) {
    get_template_part('single-amp');
  } elseif ($post_type ==='event') {
    get_template_part('single-event-revenge');
  } else {
    get_template_part('single');
  }
?>

