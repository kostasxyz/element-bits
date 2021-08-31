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
 * @todo refactor pickadate.js with flatpicker.js
 */
class EB_WH_Datepicker extends EB_Widget_Base {

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
        return 'eb-wh-datepicker';
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
        return __( 'EB: WH Datepicker', 'element-bits' );
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
        return [ 'novel', 'bits', 'datepicker', 'web hotel' ];
    }

    /**
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     * @todo decouple css
     */
    public function get_style_depends() {
        return [ 'flatpickr', 'flatpickr-theme' ];
    }

    /**
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'eb-wh-datepicker', 'flatpickr' ];
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
			'book_url',
			[
				'label' => __( 'Book url', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://myhotel.reserve-online.net', 'element-bits' ),
				'show_external' => true,
				'default' => [
					'url' => 'https://myhotel.reserve-online.net',
					'is_external' => true,
					'nofollow' => true,
				],
			]
        );

		$this->add_control(
			'cal_icon',
			[
				'label' => __( 'Calendar Icon', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => ELBITS_PATH . 'assets/svg/calendar.svg',
				],
			]
        );

        $this->end_controls_section();

        //----------------------------------------------
        // Wrap style

		$this->start_controls_section(
			'wrap_style',
			[
				'label' => __( 'Container', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'height',
			[
				'label' => __( 'Widget Height', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 30,
				'max' => 1000,
				'step' => 1,
				'default' => 60,
			]
        );

		$this->add_control(
			'wrap_border_width',
			[
				'label' => __( 'Border width', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 80,
				'step' => 1,
                'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .eb-datepicker-container' => 'border: {{VALUE}}px solid;',
				],
			]
        );

		$this->add_control(
			'wrap_border_color',
			[
				'label' => __( 'Border color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#ddd',
                'selectors' => [
                    '{{WRAPPER}} .eb-datepicker-container' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .eb-datepicker-field > button:after' => 'background-color: {{VALUE}}',
                ]
			]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wrap_box_shadow',
				'label' => __( 'Box Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .eb-datepicker-container',
			]
		);

        $this->end_controls_section();

        //----------------------------------------------------
        // Labels date styles
		$this->start_controls_section(
			'label_style',
			[
				'label' => __( 'Label', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label Color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#444',
                'selectors' => [
					'{{WRAPPER}} .eb-datepicker-field-label' => 'color: {{VALUE}}',
				],
			]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Typography', 'element-bits' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-datepicker-field-label',
			]
		);

        $this->end_controls_section();

        //----------------------------------------------------
        // Display date styles
		$this->start_controls_section(
			'date_style',
			[
				'label' => __( 'Date', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'date_colors',
			[
				'label' => __( 'Date Color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .eb-datepicker-field-display-typo' => 'color: {{VALUE}}',
                ]
			]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'label' => __( 'Typography', 'element-bits' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-datepicker-field-display-typo'
			]
        );

		$this->add_control(
			'date_v_pos',
			[
				'label' => __( 'Date Vertical posistion', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -30,
				'max' => 30,
				'step' => 1,
                'default' => -3,
                'selectors' => [
                    '{{WRAPPER}} .eb-datepicker-field-display' => 'transform: translateY({{VALUE}}px)'
                ]
			]
        );

        $this->end_controls_section();

        //----------------------------------------------
        // Icon style

		$this->start_controls_section(
			'cal_style',
			[
				'label' => __( 'Icon', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );


		$this->add_control(
			'cal_color',
			[
				'label' => __( 'Icon Color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#999',
			]
		);

		$this->add_control(
			'cal_height',
			[
				'label' => __( 'Icon height', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 80,
				'step' => 1,
				'default' => 16,
			]
        );

        $this->end_controls_section();

        //----------------------------------------------
        // Button style

		$this->start_controls_section(
			'btn_style',
			[
				'label' => __( 'Button', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Text', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#eee',
                'selectors' => [
                    '{{WRAPPER}} .eb-datepicker-field-book-btn a' => 'color: {{VALUE}}',
                ]
			]
        );

		$this->add_control(
			'btn_text_hov',
			[
				'label' => __( 'Text hover', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#eee',
                'selectors' => [
                    '{{WRAPPER}} .eb-datepicker-field-book-btn a:hover' => 'color: {{VALUE}}',
                ]
			]
        );

		$this->add_control(
			'btn_bg',
			[
				'label' => __( 'Background', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .eb-datepicker-field-book-btn a' => 'background-color: {{VALUE}}',
                ]
			]
        );

		$this->add_control(
			'btn_bg_hov',
			[
				'label' => __( 'Background hover', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .eb-datepicker-field-book-btn a:hover' => 'background-color: {{VALUE}}',
                ]
			]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Typography', 'element-bits' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-datepicker-field-book-btn a'
			]
		);

        $this->end_controls_section();
    }

    /**
     * Parse svg
     *
     */
    private function parse_svg($svg) {
        $settings = $this->get_settings_for_display();

        $svg  = preg_replace('#\s(id|class|style)="[^"]+"#', ' ', $svg);
        $svg  = str_replace('<svg', '<svg class="eb-wh-datepicker-icon"', $svg);
        $svg  = str_replace('<svg', '<svg width="'.absint($settings['cal_height']).'" ', $svg);
        $svg  = str_replace('<svg', '<svg height="100%" ', $svg);
        $svg  = str_replace('<svg', '<svg fill="'.$settings['cal_color'].'" ', $svg);
        $svg  = preg_replace('/<!--(.*?)-->/', '', $svg);

        return $svg;
    }

    /**
     * Render icon
     *
     * @todo Check for svg or png, add style controls
     */
    private function render_icon() {
        $settings = $this->get_settings_for_display();

        if ( ! isset( $settings['cal_icon']['url'] ) ) {
			return '';
        }

        $ext = pathinfo($settings['cal_icon']['url'], PATHINFO_EXTENSION);

        $filepath = isset( $settings['cal_icon']['id'] ) &&  $settings['cal_icon']['id'] != ''?
                    get_attached_file( $settings['cal_icon']['id'] ) :
                    $settings['cal_icon']['url'];

        if ( $ext === 'svg' ) {
            $svg = file_get_contents( $filepath );
            return $this->parse_svg( $svg );
        }
        else {
            return '<img src="' . esc_url( $settings['cal_icon']['url'] ) . '"/>';
        }


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
        $day = date( 'd' );
        $month = date( 'M' );
        $checkin = explode( '-', date( 'd-M' ) );
        $checkout = explode( '-', date( 'd-M', strtotime(' +2 days') ) );

        $this->add_render_attribute(
            'book_btn',
            [
                'class'   => [ 'eb-datepicker-btn', 'eb-datepicker-book-btn' ],
                'href'    => $settings['book_url']['url'],
                'target'  => $settings['book_url']['is_external'] ? '_bank' : '_self',
            ]
        );

        $w_data = [
            'book_url' => $settings['book_url']['url'],
        ];
        ?>
            <div class="eb-datepicker-wrapper" data-elbits='<?php echo json_encode( $w_data ); ?>'>
                <div class="eb-datepicker-container" style="height:<?php echo absint($settings['height']); ?>px">
                    <div class="eb-datepicker-field eb-datepicker-field-checkin">
                        <button>
                            <div class="eb-datepicker-field-inner">
                                <span class="eb-datepicker-field-label">
                                    <?php _e( 'CHECKIN', 'elbits' ); ?>
                                </span>
                                <span class="eb-datepicker-field-display eb-datepicker-field-display-typo">
                                    <?php echo $checkin[0]; ?>
                                    <?php echo $checkin[1]; ?>
                                </span>
                                <span class="eb-datepicker-field-icon">
                                    <?php echo $this->render_icon(); ?>
                                </span>
                            </div>
                        </button>
                    </div>

                    <div class="eb-datepicker-field eb-datepicker-field-checkout">
                        <button>
                            <div class="eb-datepicker-field-inner">
                                <span class="eb-datepicker-field-label">
                                    <?php _e( 'CHECKOUT', 'element-bits' ); ?>
                                </span>
                                <span class="eb-datepicker-field-display eb-datepicker-field-display-typo">
                                    <?php echo $checkout[0]; ?>
                                    <?php echo $checkout[1]; ?>
                                </span>
                                <span class="eb-datepicker-field-icon">
                                <?php echo $this->render_icon(); ?>
                                </span>
                            </div>
                        </button>
                    </div>

                    <div class="eb-datepicker-field eb-datepicker-field-guests">
                        <div class="eb-datepicker-field-inner">
                            <span class="eb-datepicker-field-label">
                                <?php _e( 'GUESTS', 'element-bits' ); ?>
                            </span>
                            <?php echo $this->render_num_field(); ?>
                        </div>
                    </div>

                    <div class="eb-datepicker-field eb-datepicker-field-book-btn">
                        <a <?php echo $this->get_render_attribute_string( 'book_btn' ); ?>
                            rel="noreferrer noopener">
                            <?php _e( 'BOOK NOW', 'element-bits' ); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php

    }

    public function render_num_field() {
        return '
            <div class="eb-number-field">
            <span class="eb-number-field-sub">-</span>
            <span class="eb-number-field-num eb-datepicker-field-display-typo">2</span>
            <span class="eb-number-field-add">+</span>
            </div>
        ';
    }

    public function cal_icon($width = '14px', $fill = '#444') {
        return '
            <svg
                version="1.1" id="eb-icon-calendar" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 425 425" xml:space="preserve" width="'.$width.'" fill="'.$fill.'">
            <g>
                <path d="M293.333,45V20h-30v25H161.667V20h-30v25H0v360h425V45H293.333z M131.667,75v25h30V75h101.667v20h30V75H395v50H30V75
                    H131.667z M30,375V155h365v220H30z"/>
                <rect x="97.5" y="285" width="50" height="50"/>
                <rect x="187.5" y="285" width="50" height="50"/>
                <rect x="277.5" y="285" width="50" height="50"/>
                <rect x="187.5" y="195" width="50" height="50"/>
                <rect x="277.5" y="195" width="50" height="50"/>
                <rect x="97.5" y="195" width="50" height="50"/>
            </g>
            </svg>
        ';
    }
}
