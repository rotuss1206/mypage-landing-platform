<?php
if (!defined('ABSPATH')) exit;

$post_id = get_the_ID();

$head_html = get_post_meta($post_id, '_mplp_head_html', true);
$body_html = get_post_meta($post_id, '_mplp_body_html', true);
$head_js   = get_post_meta($post_id, '_mplp_head_js', true);
$footer_js = get_post_meta($post_id, '_mplp_footer_js', true);

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?= $head_html; ?>

  <?php if ($head_js): ?>
    <script><?= $head_js; ?></script>
  <?php endif; ?>

</head>
<body>

<?= $body_html; ?>

<?php if ($footer_js): ?>
  <script><?= $footer_js; ?></script>
<?php endif; ?>

</body>
</html>
