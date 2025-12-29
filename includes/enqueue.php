<?php

add_action('admin_enqueue_scripts', function ($hook) {

  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;

  global $post;

  if (!$post || $post->post_type !== 'landing') return;

  wp_enqueue_code_editor([
    'type' => 'text/html',
    'codemirror' => [
      'lineNumbers'       => true,
      'indentUnit'        => 2,
      'tabSize'           => 2,
      'indentWithTabs'    => false,
      'lineWrapping'      => true,
      'autoCloseTags'     => true,
      'autoCloseBrackets' => true,
      'matchBrackets'     => true,
    ],
  ]);

  wp_enqueue_script('wp-theme-plugin-editor');
  wp_enqueue_style('wp-codemirror');

  wp_enqueue_script(
    'mplp-code-editor',
    MPLP_URL . '/assets/code-editor.js',
    ['jquery', 'wp-codemirror'],
    null,
    true
  );

});
