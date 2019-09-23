<?php
/*
Plugin name: PekorKort-wp
Plugin URI: http://localhost
Description: Pekokort Drive Test plugin
Version: V0.3.0
Author: RavandSoft
Author URI: http://localhost
Text Domain: -e('PekorKort-wp','PekorKort-wp')
 */
defined('ABSPATH') || exit('No Direct Access.');
define('PEKORKORT_DIR', plugin_dir_path(__FILE__));
define('PEKORKORT_URL', plugin_dir_url(__FILE__));
define('PEKORKORT_CSS_URL', trailingslashit(PEKORKORT_URL . 'assets/css'));
define('PEKORKORT_JS_URL', trailingslashit(PEKORKORT_URL . 'assets/js'));
define('PEKORKORT_IMG_URL', trailingslashit(PEKORKORT_URL . 'assets/img'));
define('PEKORKORT_INC_DIR', trailingslashit(PEKORKORT_DIR . 'include'));
define('PEKORKORT_ADMIN_DIR', trailingslashit(PEKORKORT_DIR . 'admin'));
define('PEKORKORT_TPL_DIR', trailingslashit(PEKORKORT_DIR . 'template'));
define('PEKORKORT_VERSION', "0.1.0");

include PEKORKORT_INC_DIR . 'class/db/db.php';
include PEKORKORT_INC_DIR . 'class/Generator/Generator.php';
require PEKORKORT_INC_DIR . 'assets.php';
require PEKORKORT_INC_DIR . 'shortcodes.php';
// require PEKORKORT_DIR . 'sample/dbSample.php';

register_activation_hook(__FILE__, 'jal_install');
add_action('plugins_loaded', 'PEKORKORT_textdomain');
function PEKORKORT_textdomain()
{
	load_plugin_textdomain('PekorKort-wp', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

if (is_admin()) {
	require_once PEKORKORT_ADMIN_DIR . 'admin.php';
}
