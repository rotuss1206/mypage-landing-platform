<?php
if (!defined('ABSPATH')) exit;

$post_id = get_the_ID();

$mode = get_post_meta($post_id, '_mplp_render_mode', true) ?: 'html_js';

$only_html = get_post_meta($post_id, '_mplp_only_html', true);

$head_html = get_post_meta($post_id, '_mplp_head_html', true);
$body_html = get_post_meta($post_id, '_mplp_body_html', true);
$head_js   = get_post_meta($post_id, '_mplp_head_js', true);
$footer_js = get_post_meta($post_id, '_mplp_footer_js', true);


// MODE: ONLY HTML 
if ($mode === 'only_html') {

    // Needed for admin bar
    if (is_user_logged_in() && is_admin_bar_showing()) {
      add_action('wp_head', function () {
          wp_enqueue_admin_bar_bump_styles();
      });

      // HTML
      echo $only_html;

      wp_admin_bar_render();

      wp_footer();
    }else{
      
      // HTML
      echo $only_html;
    }

    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <?php
    // Custom HEAD HTML
    echo $head_html;

    // HEAD JS
    if ($head_js) {
        echo '<script>' . $head_js . '</script>';
    }

    wp_head();
    ?>
</head>
<body <?php body_class(); ?>>

  <?php
  // BODY HTML
  echo $body_html;
  ?>

  <?php
  // FOOTER JS
  if ($footer_js) {
      echo '<script>' . $footer_js . '</script>';
  }

wp_footer();
?>
</body>
</html>