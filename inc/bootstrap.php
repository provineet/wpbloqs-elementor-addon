<?php

namespace WPBLOQS_ELEMENTOR_ADDONS;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Bootstrap
{

    // instance container
    private static $instance = null;

    // request unique id container
    protected $uid = null;

    // modules
    protected $installer;

    /**
     * Singleton instance
     *
     * @since 3.0.0
     */
    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor of plugin class
     *
     * @since 3.0.0
     */
    private function __construct()
    {
        // Elementor Dynamic Tags
        new \WPBLOQS_ELEMENTOR_ADDONS\DYNAMIC_TAGS\Dynamic_Tags_Loader;

        // Register Post Meta
        \WPBLOQS_ELEMENTOR_ADDONS\META\meta::register_meta();
    }
}
