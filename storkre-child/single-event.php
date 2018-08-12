<?php global $amp_flag;
  if (is_single() && $_GET['amp'] === '1') {
    $amp_flag = true;
  }

  if ($amp_flag) {
    get_template_part('single-amp');
  } else {
    get_template_part('single');
  }
?>

