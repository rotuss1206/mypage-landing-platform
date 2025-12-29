<?php
if (!defined('ABSPATH')) exit;

add_action('template_redirect', function () {

  if (is_admin()) return;

  $host = preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
  $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

  /**
   * Custom domain mode
   * example: clientdomain.com
   */
  $domain_query = new WP_Query([
    'post_type' => 'landing',
    'meta_key' => '_mplp_domain',
    'meta_value' => $host,
    'posts_per_page' => 1
  ]);

  if ($domain_query->have_posts()) {

    $domain_query->the_post();
    include MPLP_PATH . 'templates/landing-render.php';
    exit;
  }

  /**
   * Slug preview mode
   * example: mypage.is/slug
   */
  if ($path) {
      $path_parts = explode('/', $path);
      $slug = end($path_parts);

      $slug_query = new WP_Query([
          'post_type' => 'landing',
          'name' => $slug,
          'posts_per_page' => 1,
          'post_status' => 'publish',
      ]);

      if ($slug_query->have_posts()) {
          $slug_query->the_post();
          global $post;
          setup_postdata($post);
          include MPLP_PATH . 'templates/landing-render.php';
          wp_reset_postdata();
          exit;
      }
  }

});
