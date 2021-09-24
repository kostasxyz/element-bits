<?php
namespace ElementBits\Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Element bits wpml lang switch popup.
 *
 * @todo Fix styling options
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.0
 * @version 1.1
 */
class EB_Wpml_Lang_Switch extends EB_Widget_Base {

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
        return 'eb-wpml-lang-switch';
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
        return __( 'EB: Wpml Lang Switch', 'element-bits' );
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
        return [ 'novel', 'bits', 'wpml', 'switch', 'eb' ];
    }

    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'eb-wpml-lang-switch' ];
    }

    /**
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
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
    protected function _register_controls() {

        // Handle
        $this->start_controls_section(
            'content_section_handle',
            [
                'label' => __( 'Handle', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'flag_style',
            [
                'label' => __( 'Flag Style', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'rounded',
                'options' => [
                    'rounded'  => __( 'Rounded', 'element-bits' ),
                    'circle' => __( 'Circle', 'element-bits' ),
                ],
            ]
        );

        $this->add_control(
            'handle',
            [
                'label' => __( 'Choose handle style', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flag' => [
                        'title' => __( 'Flag', 'element-bits' ),
                        'icon' => 'eicon-map-pin',
                    ],
                    'code' => [
                        'title' => __( 'Code', 'element-bits' ),
                        'icon' => 'eicon-code',
                    ],
                    'flag_code' => [
                        'title' => __( 'Flag & Code', 'element-bits' ),
                        'icon' => 'eicon-globe',
                    ],
                ],
                'default' => 'flag',
                'toggle' => true,
            ]
        );

        $this->add_responsive_control(
            'handle_align',
            [
                'label' => __( 'Alignment', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'element-bits' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'element-bits' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'element-bits' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'handle_typo',
                'label' => __( 'Handle Typography', 'element-bits' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-lang-switch-handle',
            ]
        );

        $this->add_control(
            'handle_color',
            [
                'label' => __( 'Handle Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#222',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-lang-switch-handle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'handle_flag_width',
            [
                'label' => __( 'Handle flag width', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 100,
                'step' => 1,
                'default' => 32,
            ]
        );

        $this->end_controls_section(); // Handle

        // Modal
        $this->start_controls_section(
            'content_section_modal',
            [
                'label' => __( 'Modal', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => __( 'Overlay Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.6)',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-modal-overlay' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'modal_box_shadow',
                'label' => __( 'Modal Box Shadow', 'element-bits' ),
                'selector' => '{{WRAPPER}} .eb-modal',
            ]
        );

        $this->add_control(
            'modal_bg_color',
            [
                'label' => __( 'Modal BG Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-modal' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'modal_border',
                'label' => __( 'Modal Border', 'element-bits' ),
                'selector' => '{{WRAPPER}} .eb-modal',
            ]
        );

        $this->add_control(
            'modal_border_radius',
            [
                'label' => __( 'Modal Border Radius', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .eb-modal' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'modal_close_color',
            [
                'label' => __( 'Modal Close btn Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lang_list_typo',
                'label' => __( 'Lang List Typography', 'element-bits' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-lang-switch-lang-item',
            ]
        );

        $this->end_controls_section(); // Modal

        // Lang list
        $this->start_controls_section(
            'content_section_lang_list',
            [
                'label' => __( 'Modal Lang list', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lang_list_style',
            [
                'label' => __( 'Languages style', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid'  => __( 'Grid only flags', 'element-bits' ),
                    'list' => __( 'List flags and names', 'element-bits' ),
                ],
            ]
        );

        $this->add_control(
            'flags_width',
            [
                'label' => __( 'Language flags width', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 100,
                'step' => 1,
                'default' => 64,
            ]
        );

        // $this->add_control(
        //     'lang_list_bg_hover_color',
        //     [
        //         'label' => __( 'Language List BG Hover Color', 'element-bits' ),
        //         'type' => \Elementor\Controls_Manager::COLOR,
        //         'default' => '#f7f7f7',
        //         'scheme' => [
        //             'type' => \Elementor\Core\Schemes\Color::get_type(),
        //             'value' => \Elementor\Core\Schemes\Color::COLOR_1,
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .eb-lang-switch-lang-item:hover' => 'background: {{VALUE}}',
        //         ],
        //     ]
        // );

        $this->add_control(
            'lang_list_color',
            [
                'label' => __( 'Language List Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-lang-switch-lang-item' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'lang_list_hover_color',
            [
                'label' => __( 'Language List Hover Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-lang-switch-lang-item:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section(); // Lang list
    }

    private function langs() {
        if ( function_exists('icl_object_id') ) {
            return apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );
        }

        return false;
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
        <div class="eb-lang-switch" data-eb-eid="<?php echo esc_attr( $this->get_id() ); ?>">
            <?php if( $langs = $this->langs() ) : ?>

                <?php $this->display_lang_switch(); ?>

                <?php $this->display_language_links(); ?>

            <?php else : ?>
                <p>WPML is not installed</p>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Render icon list
     */
    private function render_icon_list($settings) {

    }

    /**
     * Render languages list
     *
     * @since 1.3
     */
    private function display_language_links() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'ul-list', [
            'class' => [
                'eb-wpml-lang-switch-list',
                'eb-wpml-lang-switch-list--' . $settings['lang_list_style'],
            ]
        ]);
        ?>
        <div class="eb-modal-container ebjs-modal-container">
            <div class="eb-modal-overlay"></div>
            <div class="eb-modal">
                <div class="eb-modal-header">
                    <h4><?php _e( 'Select your language', 'element-bits' ); ?></h4>
                    <div class="eb-modal-close">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 496.096 496.096" width="18">
                            <g>
                                <path
                                    fill="<?php echo esc_attr( $settings['modal_close_color'] ); ?>"
                                    d="M259.41,247.998L493.754,13.654c3.123-3.124,3.123-8.188,0-11.312c-3.124-3.123-8.188-3.123-11.312,0L248.098,236.686    L13.754,2.342C10.576-0.727,5.512-0.639,2.442,2.539c-2.994,3.1-2.994,8.015,0,11.115l234.344,234.344L2.442,482.342    c-3.178,3.07-3.266,8.134-0.196,11.312s8.134,3.266,11.312,0.196c0.067-0.064,0.132-0.13,0.196-0.196L248.098,259.31    l234.344,234.344c3.178,3.07,8.242,2.982,11.312-0.196c2.995-3.1,2.995-8.016,0-11.116L259.41,247.998z"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <ul <?php echo $this->get_render_attribute_string( 'ul-list' ); ?>>
                        <?php foreach ( $this->langs() as $l ) : ?>
                            <li>
                                <a
                                    href="<?php echo esc_url( $l['url'] ); ?>"
                                    class="eb-lang-switch-lang-item"
                                    data-eb-eid="<?php echo esc_attr( $this->get_id() ); ?>">
                                    <img
                                        class="eb-lang-switch-flag <?php echo $settings['flag_style'] == 'circle' ? 'eb-lang-switch-flag-circle' : null; ?>"
                                        style="width:<?php echo esc_attr( $settings['flags_width'] ); ?>px"
                                        src="<?php echo esc_url( ELBITS_URL . 'assets/svg/flags/' . $settings['flag_style'] . '/' .$l['language_code'] . '.svg' ); ?>"
                                        alt="Language flag for <?php echo esc_attr( $l['native_name'] ); ?>"/>
                                    <?php if( $settings['lang_list_style'] == 'list' ) : ?>
                                        <span>
                                            <?php echo esc_attr( $l['native_name'] ); ?>
                                            (<?php echo strtoupper( esc_attr( $l['language_code'] ) ); ?>)
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render language switch
     *
     * @since 1.3
     */
    private function display_lang_switch() {
        $settings = $this->get_settings_for_display();

        if( $langs = $this->langs() ) :
        ?>
            <?php foreach ( $langs as $l ) : ?>
                <?php if( $l['active'] ) : ?>
                    <a
                        href="#"
                        class="eb-lang-switch-handle ebjs-lang-switch-modal-open"
                        data-eb-eid="<?php echo esc_attr( $this->get_id() ); ?>"
                        style="justify-content:<?php echo esc_attr( $settings['handle_align'] ); ?>">

                        <?php if( $settings['handle'] === 'code' || $settings['handle'] === 'flag_code' ) : ?>
                            <span><?php echo strtoupper( esc_attr( $l['language_code'] ) ); ?></span>
                            <?php echo $settings['handle'] === 'flag_code' ? '&nbsp;' : null ?>
                        <?php endif; ?>

                        <?php if( $settings['handle'] === 'flag' || $settings['handle'] === 'flag_code' ) : ?>
                            <img
                                class="eb-lang-switch-flag <?php echo $settings['flag_style'] == 'circle' ? 'eb-lang-switch-flag-circle' : null; ?>"
                                style="width:<?php echo esc_attr( $settings['handle_flag_width'] ); ?>px"
                                src="<?php echo esc_url( ELBITS_URL . 'assets/svg/flags/' . $settings['flag_style'] . '/' .$l['language_code'] . '.svg' ); ?>"
                                alt="Language flag for <?php esc_attr( $l['translated_name'] ); ?>"/>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif;
    }
}
