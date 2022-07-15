<?php

	namespace WPBLOQS_ELEMENTOR_ADDONS\WIDGETS\ANCHOR_TABS;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Anchor_Tabs_Widget extends \Elementor\Widget_Base {


	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'anchor_tabs';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Anchor Tabs', 'wpbloqs-elementor-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-anchor';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return '';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wpbloqs' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'anchor', 'tabs', 'scroll', 'navigation' );
	}

	/**
	 * Get scripts dependencies
	 *
	 * Return the JS files handles required by the widget
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array JS Handles.
	 */
	public function get_script_depends() {

		$script_version = filemtime( WPBEL_ASSET_URL . '/js/wpb_scripts.js' );

		wp_register_script( 'wpb_scripts', WPBEL_ASSET_URL . '/js/wpb_scripts.js', array(), $script_version, true );

		return array(
			'wpb_scripts',
		);
	}

	/**
	 * Get styles dependecies
	 *
	 * Return the CSS files handles required by the widget
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array Widget keywords.
	 */
	public function get_style_depends() {

		$style_version = filemtime( WPBEL_ASSET_URL . '/css/wpb_widgets.css' );

		wp_register_style( 'wpbloqs-styles', WPBEL_ASSET_URL . '/css/wpb_widgets.css', array(), $style_version, 'all' );

		return array(
			'wpbloqs-styles',
		);
	}

	/**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @access protected
	 * @since 1.0.0
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'wpbloqs-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

				$this->add_control(
					'list_style',
					array(
						'label'   => esc_html__( 'Layout', 'wpbloqs-elementor-addon' ),
						'type'    => \Elementor\Controls_Manager::CHOOSE,
						'options' => array(
							'default' => array(
								'title' => esc_html__( 'Default', 'wpbloqs-elementor-addon' ),
								'icon'  => 'eicon-editor-list-ul',
							),
							'inline'  => array(
								'title' => esc_html__( 'Inline', 'wpbloqs-elementor-addon' ),
								'icon'  => 'eicon-ellipsis-h',
							),
						),
						'default' => 'inline',
						'toggle'  => true,
					)
				);

			$this->add_control(
				'tab_type',
				array(
					'label'        => esc_html__( 'Tab Type', 'wpbloqs-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Meta', 'wpbloqs-elementor-addon' ),
					'label_off'    => esc_html__( 'Custom', 'wpbloqs-elementor-addon' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'       => esc_html__( 'Label', 'wpbloqs-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Tab Label', 'wpbloqs-elementor-addon' ),
				'default'     => esc_html__( 'Tab Label', 'wpbloqs-elementor-addon' ),
				'label_block' => true,
			)
		);

			$repeater->add_control(
				'link',
				array(
					'label'       => esc_html__( 'Anchor', 'wpbloqs-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Anchor Name', 'wpbloqs-elementor-addon' ),
					'label_block' => true,
				)
			);

			$repeater->add_control(
				'icon-set',
				array(
					'label'   => esc_html__( 'Icon', 'wpbloqs-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'none',
					'options' => array(
						'none'   => esc_html__( 'None', 'wpbloqs-elementor-addon' ),
						'custom' => esc_html__( 'Custom', 'wpbloqs-elementor-addon' ),
					),
				)
			);

			$repeater->add_control(
				'icon',
				array(
					'type'        => \Elementor\Controls_Manager::ICONS,
					'default'     => array(
						'value'   => 'fas fa-circle',
						'library' => 'fa-solid',
					),
					'recommended' => array(
						'fa-solid'   => array(
							'circle',
							'dot-circle',
							'square-full',
						),
						'fa-regular' => array(
							'circle',
							'dot-circle',
							'square-full',
						),
					),
					'condition'   => array(
						'icon-set' => 'custom',
					),
				)
			);

			$this->add_control(
				'tab_items',
				array(
					'label'       => esc_html__( 'Tab Items', 'wpbloqs-elementor-addon' ),
					'type'        => \Elementor\Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(), /* Use our repeater */
					'default'     => array(
						array(
							'label' => esc_html__( 'Tab #1', 'wpbloqs-elementor-addon' ),
							'link'  => '#anchor',
						),
					),
					'title_field' => '{{{ label }}}',
					'condition'   => array(
						'tab_type' => '',
					),
				)
			);

			$this->add_control(
				'meta-key',
				array(
					'label'     => esc_html__( 'Meta Key', 'plugin-name' ),
					'type'      => \Elementor\Controls_Manager::TEXT,
					'dynamic'   => array(
						'active' => true,
					),
					'condition' => array(
						'tab_type' => 'yes',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_section',
			array(
				'label' => esc_html__( 'Tab Style', 'wpbloqs-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'wpbloqs-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'wpbloqs-elementor-addon' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wpbloqs-elementor-addon' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'wpbloqs-elementor-addon' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} ul' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'wpbloqs-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul li' => 'color: {{VALUE}};',
					'{{WRAPPER}} a'     => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'icon_typography',
				'selector' => '{{WRAPPER}} li a',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} ul li a',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'label'    => esc_html__( 'Background', 'wpbloqs-elementor-addon' ),
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} ul li a',
			)
		);

		$this->add_control(
			'padding',
			array(
				'label'      => esc_html__( 'Padding', 'wpbloqs-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'margin',
			array(
				'label'      => esc_html__( 'Margin', 'wpbloqs-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'border',
			array(
				'label'      => esc_html__( 'Border Radius', 'wpbloqs-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_icon_section',
			array(
				'label' => esc_html__( 'Icon Style', 'wpbloqs-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Color', 'wpbloqs-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a i' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Size', 'wpbloqs-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em'  => array(
						'min' => 0,
						'max' => 10,
					),
					'rem' => array(
						'min' => 0,
						'max' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} a i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'wpbloqs-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em'  => array(
						'min' => 0,
						'max' => 10,
					),
					'rem' => array(
						'min' => 0,
						'max' => 10,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					// '{{WRAPPER}} .elementor-list-widget' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} a i' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 * @since 1.0.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( 'inline' === $settings['list_style'] ) {
			$this->add_render_attribute( 'list', 'class', 'wpbloqs-anchor-widget wpbloqs-list wpbloqs-inline-list' );
		} else {
			$this->add_render_attribute( 'list', 'class', 'wpbloqs-anchor-widget wpbloqs-list' );
		}

		if ( $settings['meta-key'] ) {
			$settings['tab_items'] = maybe_unserialize( $settings['meta-key'] );
		}

		?>
<ul <?php $this->print_render_attribute_string( 'list' ); ?>>
		<?php
		foreach ( $settings['tab_items'] as $index => $item ) {
					$repeater_setting_key = $this->get_repeater_setting_key( 'label', 'tab_items', $index );
					$this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-list-widget-text' );
					$this->add_inline_editing_attributes( $repeater_setting_key );
			?>
	<li <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>>
			<?php
			$title = $item['label'];

			ob_start();
			\Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) );
			$icon_html = ob_get_clean();

			if ( ! empty( $item['link'] ) ) {
				$item['link'] = array(
					'url'               => '#' . trim( $item['link'] ),
					'custom_attributes' => 'class|wpb-anchor,data-rel|smooth-scroll',
				);
				$this->add_link_attributes( "link_{$index}", $item['link'] );
				echo wp_sprintf(
					'<a %s>%s%s</a>',
					$this->get_render_attribute_string( "link_{$index}" ),
					$icon_html,
					esc_html( $title )
				);
			}
			?>
	</li>
			<?php
		}
		?>
</ul>
		<?php
	}
}
