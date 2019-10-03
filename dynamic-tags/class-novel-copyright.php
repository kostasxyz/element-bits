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
class Novel_Copyright extends \Elementor\Core\DynamicTags\Tag {

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
        return 'eb-tag-novel-logo';
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
        return __( 'EB: Novel Copyright', 'element-bits' );
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
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
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
    protected function _register_controls() {
        $this->add_control(
            'color',
            [
                'label' => __( 'Novel Logo Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'white' => 'white',
                    'blue' => 'blue'
                ],
            ]
        );

        $this->add_control(
            'logo_adj',
            [
                'label' => __( 'Adjust logo vertical position', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -100,
                'max' => 100,
                'step' => 1,
                'default' => -1,
            ]
        );

        $this->add_control(
            'logo_height',
            [
                'label' => __( 'Adjust logo height', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 100,
                'step' => 1,
                'default' => 14,
            ]
        );
    }

    /**
     * Render
     *
     * Prints out the value of the Dynamic tag
     *
     * @since 2.0.0
     * @access public
     * @todo Fix kses parenthesis issue
     * @return void|array
     */
    public function render() {
        $color       = $this->get_settings( 'color' ) ?: 'blue';
        $logo_adj    = $this->get_settings( 'logo_adj' ) ?: -1;
        $logo_height = $this->get_settings( 'logo_height' ) ?: 14;

        echo '<span class="eb-dtag-novel-copyright">Powered by <a href="https://noveldigital.pro" title="Novel Digital Agency Cyprus Web Design" target="_blank"><img style="transform:translateY('.esc_attr($logo_adj).'px);height:'.$logo_height.'px" src="'.esc_url( get_theme_file_uri( 'assets/svg/novel/novel-logo-'.$color.'.svg' ) ).'" alt="Novel Digital Agency"></a></span>';
    }
}
