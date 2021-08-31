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
class EB_Weather extends EB_Widget_Base {

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
        return 'eb-weather';
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
        return __( 'EB: Weather', 'element-bits' );
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
        return [ 'novel', 'bits', 'weather' ];
    }

    public function get_script_depends() {
        return [ 'eb-weather' ];
    }

    public function get_style_depends() {
        return [ 'eb-elements', 'weather-icons' ];
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
            'api_key',
            [
                'label' => __( 'API Key', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '705b72ed5858dfe5684e0bd7e8ce230f',
                'description' => 'https://home.openweathermap.org/api_keys',
                'placeholder' => __( 'Your openweather api key', 'element-bits' ),
            ]
        );

        $this->add_control(
            'city_name',
            [
                'label' => __( 'City Name', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '', 'element-bits' ),
                'placeholder' => __( '', 'element-bits' ),
            ]
        );

        $this->add_control(
            'units',
            [
                'label' => __( 'Units', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'metric',
                'options' => [
                    'metric'  => __( 'Metric', 'plugin-domain' ),
                    'imperial' => __( 'Imperial', 'plugin-domain' ),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => __( 'Icon', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-weather-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'rem' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 13,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-weather-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'text_style_section',
            [
                'label' => __( 'Text', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-weather-temp' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'temp_typography',
                'label' => __( 'Text Typography', 'element-bits' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-weather-temp',
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
            'eb-wrapper',
            [
                'id' => 'eb-weather-wrapper-' . $this->get_id(),
                'class' => [ 'eb-weather-wrapper' ],
                'data-eb-widget' => [
                    'widget_id' => $this->get_id(),
                    'city_name' => $settings['city_name'],
                    'api_key' => $settings['api_key'],
                    'units' => $settings['units'],
                    'eb_url' => ELBITS_URL
                ]
            ]
        );
        ?>
            <?php if( !$settings['city_name'] || !$settings['api_key'] ) : ?>
                <?php _e( 'Please enter your api key and a city name', 'element-bits' ); ?>
            <?php else : ?>
                <div <?php echo $this->get_render_attribute_string( 'eb-wrapper' ); ?>>
                    <div class="eb-eb-weather">
                        <i class="eb-weather-icon"></i>
                        <div class="eb-weather-temp"></div>
                    </div>
                </div>
            <?php endif; ?>
        <?php
    }

}
