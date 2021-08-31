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
class Novel_Powered extends EB_Widget_Base {

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
        return 'eb-novel-powered';
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
        return __( 'EB: Powered by Novel', 'element-bits' );
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
        return [ 'novel', 'bits', 'eb', 'powered' ];
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
            'heading_section',
            [
                'label' => __( 'Content', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __( 'Text', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Powered by ', 'element-bits' ),
                'placeholder' => __( '', 'element-bits' ),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-novelp-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typo',
                'label' => __( 'Typography', 'element-bits' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-novelp-text',
                'fields_options' => [
                    'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 13 ] ]
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
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
                'selectors' => [
                    '{{WRAPPER}} .eb-novelp-content' => 'display: flex; align-items: center; justify-content: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'logo_color',
            [
                'label' => __( 'Logo Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-novel-text-logo' => 'fill: {{VALUE}}',
                ],
                'default' => '#000'
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => __( 'Logo size', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 120,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0.1,
                        'max' => 120,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 42,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-novel-text-logo' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

		$this->add_control(
			'logo_margin_left',
			[
				'label' => __( 'Logo gap', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 32,
				'step' => 1,
                'default' => 6,
                'selectors' => [
                    '{{WRAPPER}} .eb-novel-text-logo' => 'margin-left: {{VALUE}}px',
                ],
			]
		);

		$this->add_control(
			'logo_vpos',
			[
				'label' => __( 'Logo Vertical align', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -32,
				'max' => 32,
				'step' => 1,
                'default' => -1,
                'selectors' => [
                    '{{WRAPPER}} .eb-novel-text-logo' => 'transform: translateY({{VALUE}}px)',
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

        $this->add_render_attribute(
            'eb-novel-text-logo',
            [
                'id' => 'eb-novel-text-logo-' . $this->get_id(),
                'class' => [ 'eb-novel-text-logo' ],
                'aria-hidden' => 'true',
                'focusable' => 'false',
                'viewBox' => '0 0 340.57 100.73',
                'role' => 'img',
                'xmlns' => 'http://www.w3.org/2000/svg',
            ]
        );
        ?>
        <div class="eb-elementor-widget eb-elementor-widget-novel-powered">
            <div class="eb-novelp-content">
                <div class="eb-novelp-text">
                    <?php echo esc_attr( $settings['text'] ); ?>
                </div>
                <a title="Cyprus Website Applications Design and Development" style="display:inline-block;line-height:1;" href="<?php echo esc_url( 'https://noveldigital.pro' ); ?>" target="_blank" rel="nofollow">
                    <svg <?php echo $this->get_render_attribute_string( 'eb-novel-text-logo' ); ?>>
                        <g>
                            <path id="path2" d="m125.65 18.238c-21.164 0-38.32 18.399-38.32 41.096s17.156 41.096 38.32 41.096c21.162 0 38.319-18.399 38.319-41.096 1e-3 -22.696-17.156-41.096-38.319-41.096zm0.17 68.023c-13.33 0-24.134-12.008-24.134-26.822s10.805-26.823 24.134-26.823c13.327 0 24.132 12.009 24.132 26.823 0 14.813-10.805 26.822-24.132 26.822z"/>
                            <polygon id="polygon4" transform="translate(-.065)" points="180.13 18.851 163.94 18.851 193.08 100.54 194.92 100.54 207.44 100.54 209.28 100.54 238.42 18.851 222.22 18.851 201.18 81.751"/>
                            <path id="path6" d="m313.98 67.026c0.408-2.4 0.631-4.868 0.631-7.394 0-22.697-17.157-41.097-38.32-41.097s-38.319 18.4-38.319 41.097 17.156 41.096 38.319 41.096c12.975 0 24.435-6.922 31.367-17.503l-12.344-6.755c-4.423 6.147-11.222 10.225-18.854 10.225-11.091 0-20.428-8.39-23.252-19.507h46.504c-3e-3 0-6e-3 -0.112-8e-3 -0.101zm-37.519-33.984c11.089 0 20.426 8.527 23.251 19.645h-46.505c2.826-11.118 12.164-19.645 23.254-19.645z"/>
                            <rect id="rect8" x="326.07" width="14.5" height="100.54"/>
                            <path id="path14" d="m76.64 41.097c0-22.698-17.157-41.097-38.319-41.097-21.164 0-38.321 18.399-38.321 41.097 0 0.121 7e-3 0.24 8e-3 0.36h-8e-3v59.001h14.361v-59.001c0-0.086-6e-3 -0.17-6e-3 -0.257 0-14.813 10.805-26.822 24.134-26.822 13.327 0 24.132 12.009 24.132 26.822 0 0.086-5e-3 0.171-5e-3 0.257v59.001h14.023v-59.001h-8e-3c2e-3 -0.121 9e-3 -0.24 9e-3 -0.36z"/>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
        <?php

    }
}
