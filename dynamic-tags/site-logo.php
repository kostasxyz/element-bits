<?php
namespace ElementBits\Tags;

defined( 'ABSPATH' ) || exit;

/**
 * Site logo
 * Add a dynamic tag for site logo
 *
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.1
 * @version 1.1
 */
class Site_Logo extends \Elementor\Core\DynamicTags\Data_Tag {

    /**
    * Get Name
    *
    * Returns the Name of the tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return string
    */
    public function get_name() {
        return 'eb-tag-site-logo';
    }

    /**
    * Get Title
    *
    * Returns the title of the Tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return string
    */
    public function get_title() {
        return __( 'EB: Site logo', 'element-bits' );
    }

    /**
    * Get Group
    *
    * Returns the Group of the tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return string
    */
    public function get_group() {
        return 'eb-dynamic-tags';
    }

    /**
    * Get Categories
    *
    * Returns an array of tag categories
    *
    * @since 2.0.0
    * @access public
    *
    * @return array
    */
    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
    }

    /**
    * Register Controls
    *
    * Registers the Dynamic tag controls
    *
    * @since 2.0.0
    * @access protected
    *
    * @return void
    */
    protected function _register_controls() {}

    /**
    * Render
    *
    * Prints out the value of the Dynamic tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return array
    */
    public function get_value( array $options = [] ) {
        $logo_id = get_theme_mod( 'entre_logo_lg' );

        if ( $logo_id ) {
            $url = wp_get_attachment_image_src( $logo_id, 'full' )[0];
        } else {
            $url = get_theme_file_uri( 'assets/svg/novel/novel-logo-blue.svg' );
        }

        return [
            'id' => $logo_id ?: null,
            'url' => $url,
        ];
    }
}
