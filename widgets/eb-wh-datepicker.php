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
			'calendar_icon',
			[
				'label' => __( 'Calendar Icon', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-calendar',
					'library' => 'solid',
				],
			]
		);

        $this->end_controls_section();
    }

    /**
     * Render icon
     * 
     * @todo Check for svg or png, add style controls
     */
    private function render_icon( $icon ) {
        $settings = $this->get_settings_for_display();

        if ( ! isset( $settings['calendar_icon']['value']['id'] ) ) {
			return '';
        }

        if ( strpos( $id, '.svg' ) !== false ) {
            $attachment_file = get_attached_file( $settings['calendar_icon']['value']['id'] );
            $svg = file_get_contents( $attachment_file );   
            $svg = preg_replace('#\s(id|class|style)="[^"]+"#', ' ', $svg);
            $svg = str_replace('<svg', '<svg class="eb-wh-datepicker-icon"', $svg);
            echo $svg;
        }
        else {
            return '<img src="' . esc_url( $settings['calendar_icon']['value']['url'] ) . '"/>';
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
                <div class="eb-datepicker-container">
                    <div class="eb-datepicker-field eb-datepicker-field-checkin">
                        <button>
                            <div class="eb-datepicker-field-inner">
                                <span class="eb-datepicker-field-label">CHECKIN</span>
                                <span class="eb-datepicker-field-date-text">
                                    <?php echo $checkin[0]; ?>
                                    &nbsp;
                                    <?php echo $checkin[1]; ?>
                                </span>
                                <span class="eb-datepicker-field-icon">
                                    <?php echo $this->calendar_icon(); ?>
                                </span>
                            </div>
                        </button>
                    </div>

                    <div class="eb-datepicker-field eb-datepicker-field-checkout">
                        <button>
                            <div class="eb-datepicker-field-inner">
                                <span class="eb-datepicker-field-label">CHECKOUT</span>
                                <span class="eb-datepicker-field-date-text">
                                    <?php echo $checkout[0]; ?>
                                    &nbsp;
                                    <?php echo $checkout[1]; ?>
                                </span>
                                <span class="eb-datepicker-field-icon">
                                    <?php echo $this->calendar_icon(); ?>
                                </span>
                            </div>
                        </button>
                    </div>

                    <div class="eb-datepicker-field eb-datepicker-field-guests">
                        <div class="eb-datepicker-field-inner">
                            <span class="eb-datepicker-field-label">GUESTS</span>
                            <?php echo $this->render_num_field(); ?>
                        </div>
                    </div>

                    <div class="eb-datepicker-field eb-datepicker-field-book-btn">
                        <a <?php echo $this->get_render_attribute_string( 'book_btn' ); ?>
                            rel="noreferrer noopener">
                            <?php _e( 'BOOK NOW', 'eb-widgets' ); ?>
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
            <span class="eb-number-field-num">2</span>
            <span class="eb-number-field-add">+</span>
            </div>
        ';
    }

    public function calendar_icon($width = '14px', $fill = '#444') {
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
