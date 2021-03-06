<?php
/**
 * Registers all the posts meta for our plugin.
 *
 * @package WordPress
 * @subpackage WPBloqs Elementor Addon
 * @since 1.0.0
 */

namespace WPBLOQS_ELEMENTOR_ADDONS\META;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post Meta Management
 */
abstract class Meta {

	/**
	 * Meta Box that needs to be registered
	 *
	 * @var array
	 */
	public static $meta_boxes;

	/**
	 * Register metaboxes
	 *
	 * @return void
	 */
	public static function register_meta() {

		self::$meta_boxes[] = 'anchor_tabs';

		foreach ( self::$meta_boxes as $meta_box ) :

			self::$meta_box();

		endforeach;

		// Enqueue Meta Scripts.
		add_action( 'admin_enqueue_scripts', array( 'WPBLOQS_ELEMENTOR_ADDONS\META\meta', 'admin_scripts' ) );
	}

	/**
	 * Enquque Admin Scripts
	 *
	 * @param string $hook hook from where it is called.
	 * @return void
	 */
	public static function admin_scripts( $hook ) {
		if (
			'post.php' != $hook
		) {
			return;
		}
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'wpb_meta_script', WPBEL_ASSET_URL . '/js/wpb_meta.js', array( 'jquery' ), '1.0', true );
		wp_register_style( 'wpb_meta_style', WPBEL_ASSET_URL . '/css/wpb_meta.css', false, '1.0.0' );
		wp_enqueue_style( 'wpb_meta_style' );
	}

	/**
	 * Hooking the metabox
	 *
	 * @return void
	 */
	public static function anchor_tabs() {
		// adding metaboxes.
		add_action( 'add_meta_boxes', array( '\WPBLOQS_ELEMENTOR_ADDONS\META\Anchor_Tabs', 'add' ) );
		add_action( 'save_post', array( '\WPBLOQS_ELEMENTOR_ADDONS\META\Anchor_Tabs', 'save' ) );
	}
}
