<?php
namespace ElementBits\Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Element bits mobile nav.
 *
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.0
 * @version 1.1
 */
class EB_Menu_Icon_Button extends EB_Widget_Base {

    protected $nav_menu_index = 1;

    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

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
        return 'eb-menu-icon-button';
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
        return __( 'EB: Menu Icon Button', 'element-bits' );
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
        return [ 'novel', 'bits', 'eb', 'menu', 'icon' ];
    }

    /**
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_style_depends() {
        return [ 'eb-menu-icon-button' ];
    }

    /**
     * In Version 2.6.7, in the edit mode, get_script_depends()
     * does not have access to get_settings()
     * or get_settings_for_display() functions, though it has access on the frontend
     * because they execute after the render() functions (before, render, after).
     *
     */
    public function conditional_get_script_depends() {

        if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
            return ['eb-menu-icon-button'];
        }

        if ( $this->get_settings_for_display( 'burger_color' ) == 1 ) {
            return [ 'eb-widget-mobile-nav-1' ];
        } else {
            return [ 'eb-widget-mobile-nav-2' ];
        }

    }

    /**
     * Get available wp menus
     *
     */
    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }

        return $options;
    }

    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'burger_style',
            [
                'label' => __( 'Burger Style', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'  => __( 'Style 1', 'element-bits' ),
                    '2'  => __( 'Style 2', 'element-bits' ),
                    '3'  => __( 'Style 3', 'element-bits' ),
                    '4'  => __( 'Style 4', 'element-bits' ),
                    '5'  => __( 'Style 5', 'element-bits' ),
                    '6'  => __( 'Style 6', 'element-bits' ),
                ],
            ]
        );

        $this->add_control(
            'burger_color',
            [
                'label' => __( 'Burger Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .eb-menu-icon-btn__line' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'burger_color_hover',
            [
                'label' => __( 'Burger Color (close)', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default' => '#444',
                'selectors' => [
                    '.eb-menu-icon-btn--active {{WRAPPER}} .eb-menu-icon-btn__line' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'burger_align',
            [
                'label' => __( 'Alignment', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'element-bits' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'element-bits' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'element-bits' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'flex-end',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://your-link.com', 'element-bits' ),
            ]
        );

        $this->end_controls_section();

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

        $sets = $this->get_settings_for_display();

        $this->add_render_attribute( 'btn', [
            'class' => 'eb-menu-icon-btn eb-menu-icon-btn--x-' . esc_attr( $sets['burger_style'] ) . ' ebjs-menu-icon-toggle',
        ] );

        if ( ! empty( $sets['link']['url'] ) ) {
            $this->add_link_attributes( 'btn', $sets['link'] );
        }
        ?>
            <div class="eb-menu-icon-btn-wrap" style="justify-content: <?php echo esc_attr( $sets['burger_align'] ); ?>">
                <a <?php echo $this->get_render_attribute_string( 'btn' ); ?> >
                    <div class="eb-menu-icon-btn__lines">
                        <div class="eb-menu-icon-btn__line eb-menu-icon-btn__line--1"></div>
                        <div class="eb-menu-icon-btn__line eb-menu-icon-btn__line--2"></div>
                        <div class="eb-menu-icon-btn__line eb-menu-icon-btn__line--3"></div>
                        <?php if( $sets['burger_style'] === '5' ) : ?>
                            <div class="eb-menu-icon-btn__line eb-menu-icon-btn__line--4"></div>
                            <div class="eb-menu-icon-btn__line eb-menu-icon-btn__line--5"></div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        <?php

    }
}
