<?php
if (!defined('ABSPATH')) exit;


function mplp_render_head($post_id) {

  $seo = [
    'title'       => get_post_meta($post_id, '_mplp_seo_title', true),
    'description' => get_post_meta($post_id, '_mplp_seo_description', true),
    'robots'      => get_post_meta($post_id, '_mplp_seo_robots', true),
    'canonical'   => get_post_meta($post_id, '_mplp_seo_canonical', true),

    'og_title'       => get_post_meta($post_id, '_mplp_og_title', true),
    'og_description' => get_post_meta($post_id, '_mplp_og_description', true),
    'og_image'       => get_post_meta($post_id, '_mplp_og_image', true),
  ];

  ?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php if ($seo['title']): ?>
    <title><?= esc_html($seo['title']); ?></title>
  <?php endif; ?>

  <?php if ($seo['description']): ?>
    <meta name="description" content="<?= esc_attr($seo['description']); ?>">
  <?php endif; ?>

  <?php if ($seo['robots']): ?>
    <meta name="robots" content="<?= esc_attr($seo['robots']); ?>">
  <?php endif; ?>

  <?php if ($seo['canonical']): ?>
    <link rel="canonical" href="<?= esc_url($seo['canonical']); ?>">
  <?php endif; ?>

  <!-- OpenGraph -->
  <?php if ($seo['og_title']): ?>
    <meta property="og:title" content="<?= esc_attr($seo['og_title']); ?>">
  <?php endif; ?>

  <?php if ($seo['og_description']): ?>
    <meta property="og:description" content="<?= esc_attr($seo['og_description']); ?>">
  <?php endif; ?>

  <?php if ($seo['og_image']): ?>
    <meta property="og:image" content="<?= esc_url($seo['og_image']); ?>">
  <?php endif; ?>

  <?php
}
