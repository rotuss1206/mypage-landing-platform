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
require_once MPLP_PATH . 'includes/enqueue.php';
require_once MPLP_PATH . 'includes/render_head.php';

// uploads.php пізніше

