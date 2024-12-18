<?php
namespace ElementBits\Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Element bits widget Template.
 *
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.0
 * @version 1.1
 */
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class EB_Accordion_Wp_Menu extends EB_Widget_Base {

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
        return 'eb-accordion-wp-menu';
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
        return __( 'EB: Accordion WP Menu', 'element-bits' );
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
        return [ 'novel', 'bits', 'accordion-wp-menu' ];
    }

    /**
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'eb-accordion-menu' ];
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
    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'wp_menu',
            [
                'label' => __( 'WP Menu', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->get_available_menus(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section_main_menu',
            [
                'label' => __( 'Main menu', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'link_color',
			[
				'label' => __( 'Link color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,1)',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-link' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_control(
			'link_color_hover',
			[
				'label' => __( 'Link hover color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,1)',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-link:hover' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_control(
            'link_bg_color_hover',
            [
                'label' => __( 'Link BG hover color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0)',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
                'selectors' => [
                    '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-link:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => __( 'Typography', 'element-bits' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-link',
			]
        );

        $this->add_control(
            'hr', [ 'type' => \Elementor\Controls_Manager::DIVIDER, ]
        );

        $this->add_control(
            'nav_link_display',
            [
                'label' => __( 'Main Nav Link diplay', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'block',
                'options' => [
                    'block'  => __( 'Block', 'element-bits' ),
                    'inline-block' => __( 'Inline', 'element-bits' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-link' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section_sub_menu',
            [
                'label' => __( 'Sub menu', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'subm_link_color',
            [
                'label' => __( 'Link color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,1)',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
                'selectors' => [
                    '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-sub-item' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'subm_link_color_hover',
            [
                'label' => __( 'Link hover color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,1)',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
                'selectors' => [
                    '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-sub-item:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'subm_link_bg_color_hover',
            [
                'label' => __( 'Link BG hover color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0)',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
                'selectors' => [
                    '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-sub-item:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subm_link_typography',
                'label' => __( 'Typography', 'element-bits' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-sub-item',
            ]
        );

        $this->add_responsive_control(
            'subm_padding',
            [
                'label' => __( 'Padding', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-menu--dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subm_bg',
            [
                'label' => __( 'Submenu background', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
                'default' => 'rgba(0,0,0,0)',
                'selectors' => [
                    '{{WRAPPER}} .eb-accordion-wp-menu-list .ntr-nav-menu--dropdown' => 'background-color: {{VALUE}}',
                ],
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

        $settings = $this->get_settings_for_display();
        ?>
            <div class="eb-accordion-wp-menu-wrapper">
                <?php
                wp_nav_menu([
                    'menu' => $settings['wp_menu'],
                    'container_class' => 'eb-accordion-wp-menu-list'
                ]);
                ?>
            </div>
        <?php

    }

}
