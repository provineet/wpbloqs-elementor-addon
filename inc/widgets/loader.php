<?php

namespace WPBLOQS_ELEMENTOR_ADDONS\WIDGETS;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

abstract class Loader
{

    public static function init()
    {
        // Creating WPBloqs Widget Category
        add_action('elementor/elements/categories_registered', ['\WPBLOQS_ELEMENTOR_ADDONS\WIDGETS\Loader', 'add_wpbloqs_widget_category']);

        // Registering Widgets
        add_action('elementor/widgets/register', ['\WPBLOQS_ELEMENTOR_ADDONS\WIDGETS\Loader', 'register_widgets']);
    }

    public static function register_widgets($widgets_manager)
    {
        // Anchor Tabs Widget
        $widgets_manager->register(new \WPBLOQS_ELEMENTOR_ADDONS\WIDGETS\ANCHOR_TABS\Anchor_Tabs_Widget());
    }

    public static function add_wpbloqs_widget_category($elements_manager)
    {
        $elements_manager->add_category(
            'wpbloqs',
            [
                'title' => esc_html__('WPBloqs', 'wpbloqs-elementor-addon'),
                'icon' => 'fa fa-plug',
            ]
        );
    }
}
