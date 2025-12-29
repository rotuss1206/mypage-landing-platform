<?php
if (!defined('ABSPATH')) exit;

$post_id = get_the_ID();

$body_html = get_post_meta($post_id, '_mplp_body_html', true);
$footer_js = get_post_meta($post_id, '_mplp_footer_js', true);
?><!DOCTYPE html>
<html lang="en">
<head>

  <?php mplp_render_head($post_id); ?>

  <?php wp_head(); ?>
</head>
<body>

<?= $body_html; ?>

<?php if ($footer_js): ?>
  <script><?= $footer_js; ?></script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>