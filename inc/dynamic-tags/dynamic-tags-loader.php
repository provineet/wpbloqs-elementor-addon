<?php
/**
 * Dynamic Tags Loader Class
 *
 * @package WordPress
 * @subpackage WPBloqs Elementor Addon
 * @since 1.0.0
 */

namespace WPBLOQS_ELEMENTOR_ADDONS\DYNAMIC_TAGS;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Loads for the Dynamic Tags
 */
class Dynamic_Tags_Loader {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'elementor/dynamic_tags/register', array( $this, 'register_site_dynamic_tag_group' ) );
		add_action( 'elementor/dynamic_tags/register', array( $this, 'register_tags' ) );

		// enabling HTML Output for renders.
		add_action( 'elementor/frontend/the_content', array( $this, 'render' ) );
		add_action( 'elementor/widget/render_content', array( $this, 'render' ) );
	}

	/**
	 * Registers tags.
	 */
	public function register_tags( $dynamic_tags_manager ) {
		// Reading Time Tag.
		$dynamic_tags_manager->register( new \WPBLOQS_ELEMENTOR_ADDONS\DYNAMIC_TAGS\READING_TIME\Reading_Time_Tag() );
		// Last Updated Tag.
		$dynamic_tags_manager->register( new \WPBLOQS_ELEMENTOR_ADDONS\DYNAMIC_TAGS\LAST_UPDATED\Last_Updated_Tag() );
	}

	/**
	 * Registers a new group for the tags
	 */
	public function register_site_dynamic_tag_group( $dynamic_tags_manager ) {

		$dynamic_tags_manager->register_group(
			'wpbloqs',
			array(
				'title' => esc_html__( 'WPBloqs', 'wpbloqs-elementor-addon' ),
			)
		);
	}

	/**
	 * Filters out the output before frontend rendering.
	 */
	public function render( $content ) {

		$updated_start_tag   = '<time itemprop="dateModified" datetime="' . get_post_modified_time( 'Y-m-d\TH:i:sP', true ) . '">';
		$published_start_tag = '<time itemprop="datePublished" datetime="' . get_the_date( 'Y-m-d\TH:i:sP' ) . '">';
		$end_tag             = '</time>';

		$content = str_replace( '%updated_schema_start%', $updated_start_tag, $content );
		$content = str_replace( '%published_schema_start%', $published_start_tag, $content );
		$content = str_replace( '%date_schema_end%', $end_tag, $content );

		return $content;
	}
}
