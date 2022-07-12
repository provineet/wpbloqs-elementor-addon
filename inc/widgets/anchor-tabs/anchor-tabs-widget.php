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
	 * @since 1.0.0
	 * @access public
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
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Anchor Tabs', 'elementor-list-widget' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
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
	 * @since 1.0.0
	 * @access public
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
	 * @since 1.0.0
	 * @access public
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
	 * @since 1.0.0
	 * @access public
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
	 * @since 1.0.0
	 * @access public
	 * @return array JS Handles.
	 */
	public function get_script_depends() {

		// wp_register_script('widget-script-1', plugins_url('assets/js/widget-script-1.js', __FILE__));

		// return [
		// 'widget-script-1'
		// ];
	}

	/**
	 * Get styles dependecies
	 *
	 * Return the CSS files handles required by the widget
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_style_depends() {

		$style_version = filemtime( WPBEL_ASSET_URL . 'css/wpb_widgets.css' );

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
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Tabs Content', 'elementor-list-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'list_style',
			array(
				'label'   => esc_html__( 'Layout', 'plugin-name' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'default' => array(
						'title' => esc_html__( 'Default', 'plugin-name' ),
						'icon'  => 'eicon-editor-list-ul',
					),
					'inline'  => array(
						'title' => esc_html__( 'Inline', 'plugin-name' ),
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
				'label'        => esc_html__( 'Tab Type', 'plugin-name' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Meta', 'your-plugin' ),
				'label_off'    => esc_html__( 'Custom', 'your-plugin' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		/* Start repeater */

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'       => esc_html__( 'Label', 'elementor-list-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Tab Label', 'elementor-list-widget' ),
				'default'     => esc_html__( 'Tab Label', 'elementor-list-widget' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Anchor', 'elementor-list-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Anchor Name', 'elementor-list-widget' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'icon-set',
			array(
				'label'   => esc_html__( 'Icon', 'plugin-name' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array(
					'none'   => esc_html__( 'None', 'plugin-name' ),
					'custom' => esc_html__( 'Custom', 'plugin-name' ),
				),
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label'       => esc_html__( '', 'plugin-name' ),
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

		/* End repeater */

		$this->add_control(
			'tab_items',
			array(
				'label'       => esc_html__( 'Tab Items', 'elementor-list-widget' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),           /* Use our repeater */
				'default'     => array(
					array(
						'text' => esc_html__( 'Tab #1', 'elementor-list-widget' ),
						'link' => '#anchor',
					),
				),
				'title_field' => '{{{ text }}}',
				'condition'   => array(
					'tab_type' => '',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_section',
			array(
				'label' => esc_html__( 'Tab Style', 'elementor-list-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_align',
			array(
				'label'   => esc_html__( 'Alignment', 'plugin-name' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'plugin-name' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'plugin-name' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'plugin-name' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'center',
				'toggle'  => true,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'elementor-list-widget' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-list-widget-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-list-widget-text > a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'icon_typography',
				'selector' => '{{WRAPPER}} .elementor-list-widget-text, {{WRAPPER}} .elementor-list-widget-text > a',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-list-widget-text',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'label'    => esc_html__( 'Background', 'plugin-name' ),
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .your-class',
			)
		);

		$this->add_control(
			'padding',
			array(
				'label'      => esc_html__( 'Padding', 'plugin-name' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .your-class' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'margin',
			array(
				'label'      => esc_html__( 'Margin', 'plugin-name' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .your-class' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_icon_section',
			array(
				'label' => esc_html__( 'Icon Style', 'elementor-list-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Color', 'elementor-list-widget' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-list-widget-text::marker' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Size', 'elementor-list-widget' ),
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
					// '{{WRAPPER}} .elementor-list-widget' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-list-widget' => 'padding-inline-start: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'elementor-list-widget' ),
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
					'{{WRAPPER}} .elementor-list-widget' => 'padding-inline-start: {{SIZE}}{{UNIT}};',
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
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['list_style'] === 'inline' ) {
			$this->add_render_attribute( 'list', 'class', 'wpbloqs-anchor-widget wpbloqs-list wpbloqs-inline-list' );
		} else {
			$this->add_render_attribute( 'list', 'class', 'wpbloqs-anchor-widget wpbloqs-list' );
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

			if ( ! empty( $item['link'] ) ) {
				$item['link'] = array(
					'url'               => $item['link'],
					'custom_attributes' => 'class|wpb-anchor',
				);
				$this->add_link_attributes( "link_{$index}", $item['link'] );
				$linked_title = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( "link_{$index}" ), $title );
				echo $linked_title;
			} else {
				echo $title;
			}
			?>
	</li>
	<?php
		}
		?>
</ul>
<?php
	}

	/**
	 * Render list widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
<# html_tag={ 'ordered' : 'ol' , 'unordered' : 'ul' , 'other' : 'ul' , }; view.addRenderAttribute( 'list' , 'class' , 'elementor-list-widget' ); #>
	<{{{ html_tag[ settings.marker_type ] }}} {{{ view.getRenderAttributeString( 'list' ) }}}>
		<# _.each( settings.list_items, function( item, index ) { var repeater_setting_key=view.getRepeaterSettingKey( 'text' , 'list_items' , index ); view.addRenderAttribute( repeater_setting_key, 'class' , 'elementor-list-widget-text' ); view.addInlineEditingAttributes( repeater_setting_key ); #>
			<li {{{ view.getRenderAttributeString( repeater_setting_key ) }}}>
				<# var title=item.text; #>
					<# if ( item.link ) { #>
						<# view.addRenderAttribute( `link_${index}`, item.link ); #>
							<a href="{{ item.link.url }}" {{{ view.getRenderAttributeString( `link_${index}` ) }}}>
								{{{title}}}
							</a>
							<# } else { #>
								{{{title}}}
								<# } #>
			</li>
			<# } ); #>
	</{{{ html_tag[ settings.marker_type ] }}}>
	<?php
	}
}
