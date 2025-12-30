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

    // Отримуємо дані
    $only_html  = get_post_meta($post->ID, '_mplp_only_html', true);

    $head_html  = get_post_meta($post->ID, '_mplp_head_html', true);
    $body_html  = get_post_meta($post->ID, '_mplp_body_html', true);
    $head_js    = get_post_meta($post->ID, '_mplp_head_js', true);
    $footer_js  = get_post_meta($post->ID, '_mplp_footer_js', true);

    $domain     = get_post_meta($post->ID, '_mplp_domain', true);

    $seo_title       = get_post_meta($post->ID, '_mplp_seo_title', true);
    $seo_description = get_post_meta($post->ID, '_mplp_seo_description', true);
    $seo_robots      = get_post_meta($post->ID, '_mplp_seo_robots', true);
    $seo_canonical   = get_post_meta($post->ID, '_mplp_seo_canonical', true);

    $mode = get_post_meta($post->ID, '_mplp_render_mode', true) ?: 'only_html';
    ?>

    <style>
        .mplp-tabs { display: flex; margin-bottom: 10px; cursor: pointer; }
        .mplp-tab { padding: 8px 15px; border: 1px solid #ddd; border-bottom: none; background:#f1f1f1; margin-right:2px; }
        .mplp-tab.active { background: #fff; font-weight:bold; }
        .mplp-tab-content { border:1px solid #ddd; padding:15px; background:#fff; display:none; }
        .mplp-tab-content.active { display:block; }
        .mplp-section { margin-bottom: 20px; }
        .mplp-section textarea { width:100%; font-family: monospace; }
        .mplp-section textarea[name="mplp_body_html"] { min-height:400px; }
        textarea[name="mplp_only_html"] {
            min-height: 900px;
        }
        .mplp-switch {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .mplp-switch label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .mplp-switch input {
            display: none;
        }

        .mplp-slider {
            width: 42px;
            height: 22px;
            background: #ccd0d4;
            border-radius: 11px;
            position: relative;
            transition: .2s;
        }

        .mplp-slider:before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            background: #fff;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: .2s;
        }

        input:checked + .mplp-slider {
            background: #2271b1;
        }

        input:checked + .mplp-slider:before {
            transform: translateX(20px);
        }

        .mplp-delete{
          cursor: pointer;
        }
        #mplp-assets-list li .mplp-copy-url{
          width: 100%;
          max-width: 500px;
        }
        #mplp-assets-wrapper{
          margin-top: 40px;
        }
    </style>

    <div class="mplp-switch">
        <label>
            <input type="radio" name="mplp_render_mode" value="only_html"
                <?= checked($mode, 'only_html', false); ?>>
            <span class="mplp-slider"></span>
            Only HTML
        </label>

        <label>
            <input type="radio" name="mplp_render_mode" value="html_js"
                <?= checked($mode, 'html_js', false); ?>>
            <span class="mplp-slider"></span>
            HTML + JS
        </label>
    </div>

    <div class="mplp-tabs">
        <div class="mplp-tab active" data-tab="only_html">Only HTML</div>
        <div class="mplp-tab" data-tab="html_js">HTML / JS</div>
        <div class="mplp-tab" data-tab="domain">Domain</div>
        <div class="mplp-tab" data-tab="seo">SEO</div>
        <div class="mplp-tab" data-tab="assets">Images</div>

    </div>

    <div class="mplp-tab-content active" id="tab-only_html">
        <div class="mplp-section">
            <h4>Only HTML</h4>
            <textarea name="mplp_only_html"><?= esc_textarea($only_html); ?></textarea>
        </div>
    </div>

    <div class="mplp-tab-content" id="tab-html_js">
        <div class="mplp-section">
            <h4>HEAD HTML</h4>
            <textarea name="mplp_head_html"><?= esc_textarea($head_html); ?></textarea>
        </div>
        <div class="mplp-section">
            <h4>BODY HTML</h4>
            <textarea name="mplp_body_html"><?= esc_textarea($body_html); ?></textarea>
        </div>
        <div class="mplp-section">
            <h4>HEAD JS</h4>
            <textarea name="mplp_head_js"><?= esc_textarea($head_js); ?></textarea>
        </div>
        <div class="mplp-section">
            <h4>FOOTER JS</h4>
            <textarea name="mplp_footer_js"><?= esc_textarea($footer_js); ?></textarea>
        </div>
    </div>

    <div class="mplp-tab-content" id="tab-domain">
        <div class="mplp-section">
            <h4>Custom Domain (optional)</h4>
            <input type="text" name="mplp_domain" value="<?= esc_attr($domain); ?>" placeholder="example.com" style="width:100%;">

            <div style="margin-top:10px; font-size:13px; color:#555;">
                <strong>DNS instructions:</strong><br>

                <pre style="background:#f7f7f7; padding:8px;">Type: A
                  Host / Name: @
                  Value / IP: 64.185.227.26
                  TTL: Auto
                </pre>

                <pre style="background:#f7f7f7; padding:8px;">Type: CNAME
                  Host: www
                  Value: yourdomain.com
                </pre>

                <p>No redirects or nameserver changes required. SSL enabled automatically.</p>
            </div>
        </div>
    </div>

    <div class="mplp-tab-content" id="tab-seo">
        <div class="mplp-section">
            <h3>SEO Settings</h3>

            <p><strong>Title</strong><br>
                <input type="text" name="mplp_seo_title" value="<?= esc_attr($seo_title); ?>" style="width:100%;" placeholder="Page title for Google">
            </p>

            <p><strong>Meta Description</strong><br>
                <textarea name="mplp_seo_description" rows="3" style="width:100%;" placeholder="Short description"><?= esc_textarea($seo_description); ?></textarea>
            </p>

            <p><strong>Robots</strong><br>
                <select name="mplp_seo_robots">
                    <?php
                    $robots_options = [
                        '' => 'Default (index, follow)',
                        'index, follow' => 'index, follow',
                        'noindex, follow' => 'noindex, follow',
                        'noindex, nofollow' => 'noindex, nofollow',
                    ];
                    foreach ($robots_options as $value => $label) {
                        echo '<option value="' . esc_attr($value) . '"' . selected($seo_robots, $value, false) . '>' . esc_html($label) . '</option>';
                    }
                    ?>
                </select>
            </p>

            <p><strong>Canonical URL</strong><br>
                <input type="text" name="mplp_seo_canonical" value="<?= esc_attr($seo_canonical); ?>" style="width:100%;" placeholder="https://example.com/">
                <small>Leave empty to auto-generate from domain</small>
            </p>
        </div>
    </div>

    <div class="mplp-tab-content" id="tab-assets">
        <h3>Images / Assets</h3>

        <button class="button button-primary" id="mplp-add-image">
            + Add image
        </button>

        <div id="mplp-assets-wrapper">
            <label id="mplp-select-all-wrapper" style="display:none; align-items:center;gap:5px;margin-bottom:5px;">
                <input type="checkbox" id="mplp-select-all"> Select All
            </label>

            <ul id="mplp-assets-list"></ul>

            <button class="button button-secondary" id="mplp-delete-selected" style="display:none;">
                Delete selected
            </button>
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('.mplp-tab');
        const contents = document.querySelectorAll('.mplp-tab-content');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById('tab-' + tab.dataset.tab).classList.add('active');
            });
        });
    </script>
    <?php
}


/**
 * Save fields
 */
add_action('save_post_landing', function ($post_id) {

  if (!isset($_POST['mplp_nonce']) || !wp_verify_nonce($_POST['mplp_nonce'], 'mplp_save_landing')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  update_post_meta($post_id, '_mplp_only_html', $_POST['mplp_only_html'] ?? '');

  update_post_meta($post_id, '_mplp_head_html', $_POST['mplp_head_html'] ?? '');
  update_post_meta($post_id, '_mplp_body_html', $_POST['mplp_body_html'] ?? '');
  update_post_meta($post_id, '_mplp_head_js', $_POST['mplp_head_js'] ?? '');
  update_post_meta($post_id, '_mplp_footer_js', $_POST['mplp_footer_js'] ?? '');
  update_post_meta($post_id, '_mplp_domain', sanitize_text_field($_POST['mplp_domain'] ?? ''));

  update_post_meta($post_id, '_mplp_seo_title', sanitize_text_field($_POST['mplp_seo_title'] ?? ''));
  update_post_meta($post_id, '_mplp_seo_description', sanitize_textarea_field($_POST['mplp_seo_description'] ?? ''));
  update_post_meta($post_id, '_mplp_seo_robots', sanitize_text_field($_POST['mplp_seo_robots'] ?? ''));
  update_post_meta($post_id, '_mplp_seo_canonical', esc_url_raw($_POST['mplp_seo_canonical'] ?? ''));

  update_post_meta(
    $post_id,
    '_mplp_render_mode',
    in_array($_POST['mplp_render_mode'] ?? '', ['only_html', 'html_js'], true)
        ? $_POST['mplp_render_mode']
        : 'only_html'
  );

});
