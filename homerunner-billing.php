<?php
/**
 * Plugin Name: Homerunner Billing
 * Description: Homerunner billing management wordpress plugin
 * Plugin URI: https://hudsoncreative.com/
 * Author: Rashed khan
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html 
 */

if (!defined('ABSPATH')) {
   exit;
}

// Define base file.
define('HOMEBILL_PLUGIN_FILE', __FILE__);

// Define plugin version.
define('HOMEBILL_VERSION', '1.0.2');

add_action('plugins_loaded', function () {
   include_once(__DIR__ . '/includes/Plugin.php');

   HomerunnerBilling\Plugin::get_instance();
});

register_activation_hook(__FILE__, function () {
   update_option('homebill_version', HOMEBILL_VERSION);
});