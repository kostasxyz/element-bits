<?php
namespace ElementBits\Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Element bits section header.
 *
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.0
 * @version 1.1
 */
class EB_Woo_Products_Sort extends EB_Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'eb-woo-products-sort';
    }

    /**
     * Get widget title.
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'EB: Woo Products Sort', 'element-bits' );
    }

    /**
     * Keywords
     *
     * @since 1.0.0
     * @access public
     *
     * @return array.
     */
    public function get_keywords() {
        return [ 'novel', 'bits', 'Woo', 'Products'. 'Sort', 'eb'];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'heading_section',
            [
                'label' => __( 'Content', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_menu_order',
            [
                'label' => __( 'Default sorting', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_popularity',
            [
                'label' => __( 'Sort by popularity', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_rating',
            [
                'label' => __( 'Sort by average rating', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_rating',
            [
                'label' => __( 'Sort by average rating', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => __( 'Sort by latest', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label' => __( 'Price: low to high', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_price-desc',
            [
                'label' => __( 'Price: high to low', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->end_controls_section();

    }

    /**
     * Selected option by $_GET
     *
     */
    public function selected($value) {

        $out = 'value="'.$value.'"';

        if( $_GET['orderby'] && $_GET['orderby'] == $value ) {
            $out .=  ' selected="selected"';
        }
        else {
            if( $value === 'menu_order' ) {
                $out .= ' selected="selected"';
            }
        }

        return $out;

    }

    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        ?>
        <div class="eb-woo-products-sort-widget">
            <div class="eb-eb-woo-products-sort">
                <select name="ntr-orderby" class="eb-woo-products-sort-orderby" aria-label="Shop order">
                    <option <?php echo $this->selected('menu_order'); ?>><?php _e( 'Default', 'element-bits' ); ?></option>
                    <option <?php echo $this->selected('popularity'); ?>><?php _e( 'Popular', 'element-bits' ); ?></option>
                    <option <?php echo $this->selected('rating'); ?>><?php _e( 'Rating', 'element-bits' ); ?></option>
                    <option <?php echo $this->selected('date'); ?>><?php _e( 'Latest', 'element-bits' ); ?></option>
                    <option <?php echo $this->selected('price'); ?>><?php _e( 'Price: low to high', 'element-bits' ); ?></option>
                    <option <?php echo $this->selected('price-desc'); ?>><?php _e( 'Price: high to low', 'element-bits' ); ?></option>
                </select>
            </div>
        </div>

        <script>
            (function($){
                $('.eb-woo-products-sort-orderby').on('change', function(e) {
                    e.preventDefault();
                    window.location = window.location.pathname + '?orderby=' + (e.currentTarget.value || 'menu_order');
                });
            })(jQuery);
        </script>
        <?php

    }
}
