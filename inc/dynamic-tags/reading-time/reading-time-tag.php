<?php
/**
 * Elementor Reading Time Dynamic Tag
 *
 * @package WordPress
 * @subpackage WPBloqs Elementor Addon
 * @since 1.0.0
 */

namespace WPBLOQS_ELEMENTOR_ADDONS\DYNAMIC_TAGS\READING_TIME;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Reading Time Dynamic Tag
 *
 * Elementor dynamic tag that returns the reading time for a post.
 *
 * @since 1.0.0
 */
class Reading_Time_Tag extends \Elementor\Core\DynamicTags\Tag {


	/**
	 * Stores Reading time
	 *
	 * @var string
	 */
	private $reading_time;

	/**
	 * Get dynamic tag name.
	 *
	 * Retrieve the name of the ACF average tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag name.
	 */
	public function get_name() {
		return 'reading-time';
	}

	/**
	 * Get dynamic tag title.
	 *
	 * Returns the title of the ACF average tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag title.
	 */
	public function get_title() {
		return esc_html__( 'Reading Time', 'wpbloqs-elementor-addon' );
	}

	/**
	 * Get dynamic tag groups.
	 *
	 * Retrieve the list of groups the ACF average tag belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Dynamic tag groups.
	 */
	public function get_group() {
		return array( 'wpbloqs' );
	}

	/**
	 * Get dynamic tag categories.
	 *
	 * Retrieve the list of categories the Reading Time tag belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Dynamic tag categories.
	 */
	public function get_categories() {
		return array( \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY );
	}

	/**
	 * Register dynamic tag controls.
	 *
	 * Add input fields to allow the user to customize the Reading Time tag settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_controls() {
		$this->add_control(
			'label',
			array(
				'label'   => esc_html__( 'Label', 'wpbloqs-elementor-addon' ),
				'type'    => 'text',
				'default' => 'Reading Time: ',
			)
		);
		$this->add_control(
			'wpm',
			array(
				'label'   => esc_html__( 'Words Per Min', 'wpbloqs-elementor-addon' ),
				'type'    => 'number',
				'default' => 300,
			)
		);
	}

	/**
	 * Render tag output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function render() {
		$wpm = $this->get_settings( 'wpm' );

		$this->calculate_reading_time( get_the_id(), $wpm );

		echo $this->get_settings( 'label' ) . esc_html( $this->reading_time );
	}

	/**
	 * Calculates the reading time
	 *
	 * @param int $post_id post id.
	 * @param int $wpm words per min.
	 * @return $this->reading_time
	 */
	public function calculate_reading_time( $post_id, $wpm ) {

		$content          = get_post_field( 'post_content', $post_id );
		$number_of_images = substr_count( strtolower( $content ), '<img ' );

		$content = strip_shortcodes( $content );

		$content = wp_strip_all_tags( $content );

		$word_count = count( preg_split( '/\s+/', $content ) );

		// Calculate additional time added to post by images.
		$additional_words_for_images = $this->calculate_images_time( $number_of_images, $wpm );
		$word_count                 += $additional_words_for_images;

		$this->reading_time = $word_count / $wpm;

		// If the reading time is 0 then return it as < 1 instead of 0.
		if ( 1 > $this->reading_time ) {
			$this->reading_time = __( '< 1 Min', 'wpbloqs-elementor-addon' );
		} else {
			$this->reading_time = ceil( $this->reading_time ) . __( ' Mins', 'wpbloqs-elementor-addon' );
		}

		return $this->reading_time;
	}

	/**
	 * Adds additional reading time for images
	 *
	 * Calculate additional reading time added by images in posts. Based on calculations by Medium. https://blog.medium.com/read-time-and-you-bc2048ab620c
	 *
	 * @since 1.0.0
	 *
	 * @param int   $total_images number of images in post.
	 * @param array $wpm words per minute.
	 * @return int  Additional time added to the reading time by images.
	 */
	public function calculate_images_time( $total_images, $wpm ) {
		$additional_time = 0;
		// For the first image add 12 seconds, second image add 11, ..., for image 10+ add 3 seconds.
		for ( $i = 1; $i <= $total_images; $i++ ) {
			if ( $i >= 10 ) {
				$additional_time += 3 * (int) $wpm / 60;
			} else {
				$additional_time += ( 12 - ( $i - 1 ) ) * (int) $wpm / 60;
			}
		}

		return $additional_time;
	}
}
