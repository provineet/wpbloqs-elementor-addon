<?php
/**
 * Meta for Anchor Tabs
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
 * Custom Post Meta for in-post Anchors
 *
 * Creates post meta.
 *
 * @since 1.0.0
 */
abstract class Anchor_Tabs {

	/**
	 * Set up and add the meta box.
	 */
	public static function add() {
		$screens = array( 'post' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'_wpb_anchor_tabs',
				'Anchor Tabs HTML',
				array( self::class, 'html' ),
				$screen
			);
		}
	}


	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 */
	public static function save( int $post_id ) {

		update_post_meta(
			$post_id,
			'_wpb_anchor_tabs',
			$_POST['wpb_anchor_id']
		);
		if ( array_key_exists( 'wpb_anchor_id', $_POST ) ) {

			$values = array();
			$list   = '';
			for ( $i = 0; $i < count( $_POST['wpb_anchor_id'] ); $i++ ) {
				if ( ( $_POST['wpb_anchor_id'][ $i ] !== '' ) && ( $_POST['wpb_tab_label'][ $i ] !== '' ) ) {
					$values[] = array( $_POST['wpb_anchor_id'][ $i ], $_POST['wpb_tab_label'][ $i ] );
					$list    .= '<a href="#' . $_POST['wpb_anchor_id'][ $i ] . '">' . $_POST['wpb_tab_label'][ $i ] . '</a>';
				}
			}

			if ( ! empty( $values ) ) {
				update_post_meta(
					$post_id,
					'_wpb_anchor_tabs',
					$values
				);
				update_post_meta(
					$post_id,
					'wpb_anchor_tabs',
					$list
				);
			} else {
				delete_post_meta( $post_id, '_wpb_anchor_tabs' );
			}
		}
	}


	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param \WP_Post $post   Post object.
	 */
	public static function html( $post ) {
		$anchors = get_post_meta( $post->ID, '_wpb_anchor_tabs', true );
		?>
<div class="anchor_group">
	<div class="wpb_fields" id="sortable">
		<?php
		if ( empty( $anchors ) ) {
			$anchors = array( array( '', '' ) );
		}
				$count = 1;
		?>
		<?php foreach ( $anchors as $anchor ) : ?>
		<fieldset id="wpb-anchor-<?php echo esc_attr( $count ); ?>">
			<div class="container">
				<div class="row">
					<div class="col-6">
						<label>ID</label>
						<input type="text" name="wpb_anchor_id[]" id="wpb_anchor_id_<?php echo $count; ?>" value="<?php echo $anchor[0]; ?>">
					</div>
					<!-- /.col-6 -->
					<div class="col-6">
						<label>Label</label>
						<input type="text" name="wpb_tab_label[]" id="wpb_tab_label_<?php echo $count; ?>" value="<?php echo $anchor[1]; ?>">
					</div>
					<!-- /.col-6 -->
					<?php
					if ( $count !== 1 ) :
						?>
					<button data-id="<?php echo 'wpb-anchor-' . esc_attr( $count ); ?>" class="wpb_delete">+</button>
					<?php
						endif;
						$count++;
					?>
					<!-- /.row -->
				</div>
				<!-- /.container -->
		</fieldset>
		<?php endforeach; ?>
	</div>
	<!-- /.fields -->
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div style="text-align: center;">
					<button type="button" class="wpb_add_button" aria-label="Add Anchor Tabs">
						Add More
					</button>
				</div>
				<!-- /.col-12 -->
			</div>
			<!-- /.col-12 -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->
</div>
<?php
	}
}
