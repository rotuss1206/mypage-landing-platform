<?php
if (!defined('ABSPATH')) exit;

add_filter('upload_dir', function ($dirs) {
    if (!isset($_REQUEST['mplp_post_id'])) {
        return $dirs;
    }

    $post = get_post((int) $_REQUEST['mplp_post_id']);
    if (!$post) return $dirs;

    $slug = sanitize_title($post->post_name); 

    $subdir = '/' . $slug; // new folder

    $dirs['subdir'] = $subdir;
    $dirs['path']   = $dirs['basedir'] . $subdir;
    $dirs['url']    = $dirs['baseurl'] . $subdir;

    return $dirs;
});

add_action('wp_ajax_mplp_add_asset', function () {
    $post_id = (int) $_POST['post_id'];
    $attachment_id = (int) $_POST['attachment_id'];

    $assets = get_post_meta($post_id, '_mplp_asset');
	if (!in_array($attachment_id, $assets, true)) {
	    add_post_meta($post_id, '_mplp_asset', $attachment_id);
	}

    wp_die();
});

add_action('wp_ajax_mplp_get_assets', function () {

    $post_id = (int) $_GET['post_id'];
    $assets = get_post_meta($post_id, '_mplp_asset');

    foreach ($assets as $id) {

	    $url = mplp_asset_url($id, $post_id);

	    $meta = wp_get_attachment_metadata($id);
	    $width = $meta['width'] ?? 0;
	    $height = $meta['height'] ?? 0;
	    ?>
	    <li style="display:flex;align-items:center;gap:10px;">
	        <img src="<?= esc_url($url); ?>" width="50">
	        <span style="font-size:12px; color:#555;"><?= $width ?>x<?= $height ?> px</span>
	        <input type="text" value="<?= esc_url($url); ?>" readonly onclick="this.select()">
	        <span class="dashicons dashicons-trash mplp-delete" data-id="<?= esc_attr($id) ?>" title="Delete"></span>
	    </li>
	    <?php
	}

    wp_die();
});

add_action('wp_ajax_mplp_delete_asset', function () {

    $id = (int) $_POST['attachment_id'];

    $posts = get_posts([
        'meta_key' => '_mplp_asset',
        'meta_value' => $id,
        'post_type' => 'landing',
        'fields' => 'ids'
    ]);

    foreach ($posts as $post_id) {
        delete_post_meta($post_id, '_mplp_asset', $id);
    }

    wp_delete_attachment($id, true);
    wp_die();
});

function mplp_asset_url($attachment_id, $post_id) {

    $post = get_post($post_id);
    if (!$post) return '';

    $slug = sanitize_title($post->post_name);

    // Get the real URL of the file
    $real_url = wp_get_attachment_url($attachment_id);
    $filename = basename($real_url);

    // Custom domain
    $custom_domain = get_post_meta($post_id, '_mplp_domain', true) ?: site_url();

    // Forming a “clean” URL
    $clean_url = rtrim($custom_domain, '/') . '/' . $slug . '/' . $filename;

    // Accessibility check (if htaccess works)
    $headers = @get_headers($clean_url);
    if ($headers && strpos($headers[0], '200') !== false) {
        return $clean_url;
    }

    // fallback to real wp-content/uploads
    return $real_url;
}

add_action('init', function () {

    // Execute only in the admin area when saving / viewing
    if (!is_admin()) return;

    $posts = get_posts([
        'post_type' => 'landing',
        'numberposts' => -1
    ]);

    foreach ($posts as $post) {
        $slug = sanitize_title($post->post_name);
        $upload_dir = wp_upload_dir();
        $folder_path = $upload_dir['basedir'] . '/' . $slug;

        if (!is_dir($folder_path)) {
            wp_mkdir_p($folder_path);
        }

        $htaccess_file = $folder_path . '/.htaccess';

        if (!file_exists($htaccess_file)) {
            $content = <<<HTACCESS
			<IfModule mod_rewrite.c>
			RewriteEngine On
			RewriteCond %{REQUEST_FILENAME} !-f
			RewriteRule ^([a-z0-9-]+)/(.+)$ /wp-content/uploads/$1/$2 [L]
			</IfModule>
			HTACCESS;
            file_put_contents($htaccess_file, $content);
        }
    }
});