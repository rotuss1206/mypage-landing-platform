<?php
if (!defined('ABSPATH')) exit;

add_action('init', function () {

  register_post_type('landing', [
    'labels' => [
      'name' => 'Landing Pages',
      'singular_name' => 'Landing Page',
    ],
    'public' => true,
    'has_archive' => false,
    'rewrite' => ['slug' => ''],
    'supports' => ['title'],
    'show_in_rest' => false,
    'menu_icon' => 'dashicons-admin-site',
  ]);

});