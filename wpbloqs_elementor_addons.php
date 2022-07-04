<?php

/**
 * Plugin Name: WPBloqs Elementor Addons
 * Description: Beautiful addons to extend your Elementor Library.
 * Plugin URI: https://wpbloqs.com
 * Author: WPBloqs Developer
 * Version: 1.0.0
 * Author URI: https://blogohblog.com/
 * Text Domain: wpbloqs-elementor-addon
 * Domain Path: /languages
 *
 * WC tested up to: 6.6.1
 * Elementor tested up to: 3.6.6
 * Elementor Pro tested up to: 3.7.2
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Defining plugin constants.
 *
 * @since 3.0.0
 */
define('WPBEL_PLUGIN_FILE', __FILE__);
define('WPBEL_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('WPBEL_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('WPBEL_PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)));
define('WPBEL_PLUGIN_VERSION', '5.1.7');
define('WPBEL_ASSET_PATH', wp_upload_dir()['basedir'] . '/essential-addons-elementor');
define('WPBEL_ASSET_URL', wp_upload_dir()['baseurl'] . '/essential-addons-elementor');

/**
 * Including composer autoloader globally.
 *
 * @since 3.0.0
 */
require_once WPBEL_PLUGIN_PATH . 'autoload.php';

/**
 * Run plugin after all others plugins
 *
 * @since 3.0.0
 */
add_action('plugins_loaded', function () {
    \WPBLOQS_ELEMENTOR_ADDONS\Classes\Bootstrap::instance();
});

// /**
//  * Activation hook
//  *
//  * @since v3.0.0
//  */
// register_activation_hook(__FILE__, function () {
//     $setup = new \WPBLOQS_ELEMENTOR_ADDONS\Classes\Setup;
//     $setup->plugin_activation_hook();
// });

// /**
//  * Deactivation hook
//  *
//  * @since v3.0.0
//  */
// register_deactivation_hook(__FILE__, function () {
//     $setup = new \WPBLOQS_ELEMENTOR_ADDONS\Classes\Setup;
//     $setup->plugin_deactivation_hook();
// });
