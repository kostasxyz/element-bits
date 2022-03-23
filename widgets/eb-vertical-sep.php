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
class EB_Vertical_Sep extends EB_Widget_Base {

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
        return 'eb-vertical-sep';
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
        return __( 'EB: Vertical Separator', 'element-bits' );
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
        return [ 'novel', 'bits', 'vertical-sep' ];
    }

    public function get_style_depends() {
        return [ 'eb-elements' ];
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
            'color',
            [
                'label' => __( 'Sep Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-vertical-sep-wrapper .eb-vertical-sep' => 'background-color: {{VALUE}}',
                ],
                'default' => '#222'
            ]
        );

        $this->add_control(
            'width',
            [
                'label' => __( 'Sep Width', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} .eb-vertical-sep-wrapper .eb-vertical-sep' => 'width: {{VALUE}}px',
                ],
            ]
        );

        $this->add_control(
            'height',
            [
                'label' => __( 'Sep Height', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'step' => 1,
                'default' => 100,
                'selectors' => [
                    '{{WRAPPER}} .eb-vertical-sep-wrapper .eb-vertical-sep' => 'height: {{VALUE}}px',
                ],
            ]
        );

        $this->add_control(
            'align',
            [
                'label' => __( 'ALign', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'flex-start' => __( 'Top', 'element-bits' ),
                    'center'     => __( 'Middle', 'element-bits' ),
                    'flex-end'   => __( 'Bottom', 'element-bits' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-vertical-sep-wrapper' => 'align-items: {{VALUE}}',
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
            <div class="eb-vertical-sep-wrapper">
                <div class="eb-vertical-sep"></div>
            </div>
        <?php

    }

}
