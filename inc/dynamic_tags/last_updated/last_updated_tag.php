<?php

namespace WPBLOQS_ELEMENTOR_ADDONS\DYNAMIC_TAGS\LAST_UPDATED;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Reading Time Dynamic Tag
 *
 * Elementor dynamic tag that returns the reading time for a post.
 *
 * @since 1.0.0
 */
class Last_Updated_Tag extends \Elementor\Core\DynamicTags\Tag
{

    private $published_at;

    private $updated_at;

    /**
     * Get dynamic tag name.
     *
     * Retrieve the name of the ACF average tag.
     *
     * @since 1.0.0
     * @access public
     * @return string Dynamic tag name.
     */
    public function get_name()
    {
        return 'last-updated';
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
    public function get_title()
    {
        return esc_html__('Last Updated At', 'wpbloqs-elementor-addon');
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
    public function get_group()
    {
        return ['wpbloqs'];
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
    public function get_categories()
    {
        return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
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
    protected function register_controls()
    {
        $this->add_control(
            'published_label',
            [
                'label' => esc_html__('Publish Label', 'wpbloqs-elementor-addon'),
                'type' => 'text',
                'default' => 'Published At:'
            ]
        );
        $this->add_control(
            'updated_label',
            [
                'label' => esc_html__('Updated Label', 'wpbloqs-elementor-addon'),
                'type' => 'text',
                'default' => 'Last Updated At:'
            ]
        );
        $this->add_control(
            'datediff',
            [
                'label' => esc_html__('Show if Difference', 'wpbloqs-elementor-addon'),
                'type' => 'number',
                'default' => 20,
                'description' => "Show updated date if the difference between the dates is more than?"
            ]
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
    public function render()
    {
        $modified_at = get_the_modified_date();

        $published_at = get_the_date();

        $diff = abs(strtotime(get_the_modified_date()) - strtotime(get_the_date()));

        $days = floor(($diff) / (60 * 60 * 24));

        if ($days < absint($this->get_settings('datediff'))) {
            $date = $this->get_settings('published_label') . '%published_schema_start%' . $published_at . '%date_schema_end%';
        } else {
            $date = $this->get_settings('updated_label') . '%updated_schema_start%' . $modified_at . '%date_schema_end%';
        }

        echo $date;
    }
}
