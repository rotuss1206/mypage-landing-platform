<?php
if (!defined('ABSPATH')) exit;

/**
 * Add meta box
 */
add_action('add_meta_boxes', function () {
  add_meta_box(
    'mplp_landing_fields',
    'Landing Page Builder',
    'mplp_render_landing_fields',
    'landing',
    'normal',
    'high'
  );
});

/**
 * Render fields
 */
function mplp_render_landing_fields($post) {

  wp_nonce_field('mplp_save_landing', 'mplp_nonce');

  $head_html  = get_post_meta($post->ID, '_mplp_head_html', true);
  $body_html  = get_post_meta($post->ID, '_mplp_body_html', true);
  $head_js    = get_post_meta($post->ID, '_mplp_head_js', true);
  $footer_js  = get_post_meta($post->ID, '_mplp_footer_js', true);
  $domain     = get_post_meta($post->ID, '_mplp_domain', true);
  ?>

  <style>
    .mplp-section { margin-bottom: 20px; }
    .mplp-section h4 { margin-bottom: 5px; }
    .mplp-section textarea { width: 100%; height: 180px; font-family: monospace; }
    .mplp-section textarea[name="mplp_body_html"] {
      min-height: 400px;
    }
  </style>

  <div class="mplp-section">
    <h4>HEAD HTML</h4>
    <p><small>&lt;title&gt;, meta, links, styles</small></p>
    <textarea name="mplp_head_html"><?= esc_textarea($head_html); ?></textarea>
  </div>

  <div class="mplp-section">
    <h4>BODY HTML</h4>
    <p><small>Main landing content (no &lt;body&gt; tag)</small></p>
    <textarea name="mplp_body_html" style="height:300px;"><?= esc_textarea($body_html); ?></textarea>
  </div>

  <div class="mplp-section">
    <h4>HEAD JS</h4>
    <p><small>Scripts that must load in &lt;head&gt;</small></p>
    <textarea name="mplp_head_js"><?= esc_textarea($head_js); ?></textarea>
  </div>

  <div class="mplp-section">
    <h4>FOOTER JS</h4>
    <p><small>Ads, conversions, tracking</small></p>
    <textarea name="mplp_footer_js"><?= esc_textarea($footer_js); ?></textarea>
  </div>

  <div class="mplp-section">
  <h4>Custom Domain (optional)</h4>

  <input
    type="text"
    name="mplp_domain"
    value="<?= esc_attr($domain); ?>"
    placeholder="example.com"
    style="width:100%;"
  >

  <div style="margin-top:10px; font-size:13px; color:#555;">
    <strong>DNS instructions:</strong><br>
    Create an <strong>A-record</strong> for your domain:
    <pre style="background:#f7f7f7; padding:8px; margin-top:6px;">
      Type: A
      Host / Name: @
      Value / IP: 64.185.227.26
      TTL: Auto
    </pre>

    Optional (recommended):
    <pre style="background:#f7f7f7; padding:8px; margin-top:6px;">
      Type: CNAME
      Host: www
      Value: yourdomain.com
    </pre>

    <p>
      No redirects or nameserver changes are required.<br>
      DNS propagation may take up to 24 hours.<br>
      SSL will be enabled automatically.
    </p>
  </div>
</div>

  <?php
}

/**
 * Save fields
 */
add_action('save_post_landing_page', function ($post_id) {

  if (!isset($_POST['mplp_nonce']) || !wp_verify_nonce($_POST['mplp_nonce'], 'mplp_save_landing')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  update_post_meta($post_id, '_mplp_head_html', $_POST['mplp_head_html'] ?? '');
  update_post_meta($post_id, '_mplp_body_html', $_POST['mplp_body_html'] ?? '');
  update_post_meta($post_id, '_mplp_head_js', $_POST['mplp_head_js'] ?? '');
  update_post_meta($post_id, '_mplp_footer_js', $_POST['mplp_footer_js'] ?? '');
  update_post_meta($post_id, '_mplp_domain', sanitize_text_field($_POST['mplp_domain'] ?? ''));

});
