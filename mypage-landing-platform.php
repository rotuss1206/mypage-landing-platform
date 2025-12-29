<?php
/**
 * Plugin Name: MyPage Landing Platform
 * Description: Platform for hosting HTML landing pages with optional custom domains.
 * Version: 0.1.0
 * Author: Vasyl
 */

if (!defined('ABSPATH')) exit;

define('MPLP_PATH', plugin_dir_path(__FILE__));
define('MPLP_URL', plugin_dir_url(__FILE__));



require_once MPLP_PATH . 'includes/cpt.php';
require_once MPLP_PATH . 'includes/admin-fields.php';
require_once MPLP_PATH . 'includes/routing.php';
// uploads.php пізніше

add_action('admin_enqueue_scripts', function ($hook) {

  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;

  global $post;
  if (!$post || $post->post_type !== 'landing_page') return;

  wp_enqueue_code_editor([
    'type' => 'text/html'
  ]);

  wp_enqueue_script(
    'mplp-code-editor',
    MPLP_URL . 'assets/code-editor.js',
    ['jquery', 'wp-code-editor'],
    '1.0',
    true
  );

});
