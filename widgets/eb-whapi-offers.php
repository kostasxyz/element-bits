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
 * @todo Refactor, implement ajax refresh offers, refactor css class names
 */
class EB_Whapi_Offers extends EB_Widget_Base {

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
        return 'eb-whapi-offers';
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
        return __( 'EB: WHapi Offers', 'element-bits' );
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
        return [ 'novel', 'bits', 'whapi-offers' ];
    }

    /**
     * Get offers
     *
     * @return array|mixed
     */
    public function get_offers() {
        $settings = $this->get_settings_for_display();

        if( $settings['dummy'] === 'yes' ) {
            return $this->dummy_offers();
        }

        $lang = apply_filters( 'wpml_current_language', null ) ?: get_locale();

        $offers = get_transient( 'entre_whapi_offers_' . $lang );

        return $offers ?: $this->fetch_offers();
    }

    /**
     * Fetch offers from web hotelier and store them in transient
     *
     * @return array|bool
     */
    public function fetch_offers() {
        $settings = $this->get_settings_for_display();

        if(
            $settings['property_code'] != '' &&
            $settings['user'] != '' &&
            $settings['key'] != '' &&
            $settings['dummy'] != 'yes' )
        {
            $args = array(
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode( esc_attr( $settings['user'] ).':'.esc_attr( $settings['key'] ) ),
                    'Accept' => 'application/json',
                    'Accept-Language' => apply_filters( 'wpml_current_language', null ) ?: get_locale()
                )
            );

            $offers_api_url = esc_url( 'https://rest.reserve-online.net/offers/' . $settings['property_code'] );

            $response = wp_remote_request( $offers_api_url, $args );

            if ( is_wp_error( $response ) ) {
                return  false;
            }

            $body = json_decode( $response['body'] );

            $data = $body->data->offers;

            set_transient( 'entre_whapi_offers_' . $lang, $data, 12 * HOUR_IN_SECONDS );

            return $data;
        }

        return [];
    }

    /**
     * Dummy offer
     *
     * @return array
     */
    private function dummy_offer( $img_i = 1 ) {
        $img = esc_url( ELBITS_URL . 'assets/images/foo' . $img_i . '.jpg' );
        $offer = new \stdClass();
        $offer->id = 123;
        $offer->name = 'Sample offer 20% off | Please enter WebHotelier API keys';
        $offer->fromd = date( 'd M Y' );
        $offer->tod = date( 'd M Y', strtotime( ' + 5 days' ) );
        $offer->active_tod = date( 'd M Y' );
        $offer->active_fromd = date( 'd M Y', strtotime( ' + 5 days' ) );
        $offer->description = 'This is a preview of the offer list. Please enter WebHotelier Username, API key and PROPERTY CODE. Insert offers at webhotelier platform and turn off "Dummy offers"';
        $offer->min_price = '199.88';
        $offer->currency = 'EUR';
        $offer->min_stay = 3;
        $offer->board_id = 19;
        $offer->board_name = 'Breakfast';
        $offer->adults = 2;
        $offer->children = 0;
        $offer->infants = 0;
        $offer->photourl = $img;
        $offer->photourlS = $img;
        $offer->photourlM = $img;
        $offer->photourlL = $img;
        $offer->bookurl = 'https://example.com';
        $offer->display = 1;

        return $offer;
    }

    private function dummy_offers() {
        return [
            $this->dummy_offer( 1 ),
            $this->dummy_offer( 2 ),
            $this->dummy_offer( 3 ),
        ];
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
            'creds_section',
            [
                'label' => __( 'Setup', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'dummy',
            [
                'label' => __( 'Use dummy offers', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'element-bits' ),
                'label_off' => __( 'No', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'yes',

            ]
        );

        $this->add_control(
            'debug',
            [
                'label' => __( 'Debug raw wh offers', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'element-bits' ),
                'label_off' => __( 'No', 'element-bits' ),
                'return_value' => 'yes',
                'default' => '',

            ]
        );

        $this->add_control(
            'user',
            [
                'label' => __( 'User', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '', 'element-bits' ),
                'condition'    => [
                    'dummy' => '',
                ],
            ]
        );

        $this->add_control(
            'key',
            [
                'label' => __( 'API key', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '', 'element-bits' ),
                'condition'    => [
                    'dummy' => '',
                ],
            ]
        );

        $this->add_control(
            'property_code',
            [
                'label' => __( 'Property Code', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '', 'element-bits' ),
                'condition'    => [
                    'dummy' => '',
                ],
            ]
        );

        $this->add_control(
            'book_engine_url',
            [
                'label' => __( 'WH Book Url', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '', 'element-bits' ),
                'condition'    => [
                    'dummy' => 'myhotel.reserve-online.net',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Meta data', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'refresh_offers',
            [
                'label' => __( 'Refresh Offers', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'success',
                'text' => __( 'Refresh', 'element-bits' ),
                'event' => 'elementbits:editor:refreshOffers',
            ]
        );
        $this->end_controls_section();


        /*
        ------------------------------------------------
            STYLE - IMAGE
        -------------------------------------------------
        */

        $this->start_controls_section(
            'image_styles',
            [
                'label' => __( 'Image', 'element-bits' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_box_shadow',
                'label' => __( 'Image shadow', 'element-bits' ),
                'selector' => '{{WRAPPER}} .ntr-whapi-offer-img',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'img_border',
                'label' => __( 'Border', 'element-bits' ),
                'selector' => '{{WRAPPER}} .ntr-whapi-offer-img',
            ]
        );

        $this->end_controls_section();

        /*
        ------------------------------------------------
            STYLE - TITLE
        -------------------------------------------------
        */

        $this->start_controls_section(
            'h_styles',
            [
                'label' => __( 'Title', 'element-bits' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'h_typography',
                'label' => __( 'Typography', 'element-bits' ),
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .ntr-whapi-offer-title',
            ]
        );

        $this->add_control(
            'h_color',
            [
                'label' => __( 'Title Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'h_color_hover',
            [
                'label' => __( 'Title Color Hover', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-title:hover a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ntr-whapi-offer-title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /*
        ------------------------------------------------
            STYLE - META
        -------------------------------------------------
        */

        $this->start_controls_section(
            'meta_styles',
            [
                'label' => __( 'Info labels', 'element-bits' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .eb-whoffers-meta-labels',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => __( 'Info labels Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-whoffers-meta-labels' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();

        /*
        ------------------------------------------------
            STYLE - PRICE
        -------------------------------------------------
        */

        $this->start_controls_section(
            'price_styles',
            [
                'label' => __( 'Price', 'element-bits' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .ntr-whapi-offer-price',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => __( 'Price Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-price' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();

        /*
        ------------------------------------------------
            STYLE - BUTTON
        -------------------------------------------------
        */

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Button', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .ntr-whapi-offer-book-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .ntr-whapi-offer-book-btn',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'element-bits' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-book-btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-book-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'element-bits' ),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __( 'Text Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-book-btn:hover, {{WRAPPER}} .ntr-whapi-offer-book-btn:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ntr-whapi-offer-book-btn:hover svg, {{WRAPPER}} .ntr-whapi-offer-book-btn:focus svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __( 'Background Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-book-btn:hover, {{WRAPPER}} .ntr-whapi-offer-book-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Border Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-book-btn:hover, {{WRAPPER}} .ntr-whapi-offer-book-btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .ntr-whapi-offer-book-btn',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-book-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .ntr-whapi-offer-book-btn',
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __( 'Padding', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ntr-whapi-offer-book-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
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
        $offers = $this->get_offers();
        ?>
            <div class="eb-whapi-offers-wrapper">
                <div class="ntr-whapi-offers-container">

                    <?php
                    if( $settings['debug'] === 'yes' ) {
                        var_dump( $this->fetch_offers() );
                    }
                    ?>

                    <?php if( $offers ) : ?>

                        <?php foreach( $offers as $offer ) : ?>
                            <?php if( $offer->display === 1 ) : ?>
                                <div id="post-<?php echo $offer->id; ?>" class="ntr-whapi-offer">
                                    <div class="ntr-whapi-offer-grid">

                                        <div class="ntr-whapi-offer-col ntr-whapi-offer-img">
                                            <a
                                                href="<?php echo esc_url( $offer->bookurl ); ?>"
                                                style="background-image:url(<?php echo esc_url( $offer->photourlM ); ?>);"
                                                target="_blank">
                                                &nbsp;
                                            </a>
                                        </div>

                                        <div class="ntr-whapi-offer-col ntr-whapi-offer-info">
                                            <?php printf( '<h3 class="ntr-whapi-offer-title"><a href="%s" target="_blank">%s</a></h3>', $offer->bookurl, $offer->name ); ?>
                                            <div class="ntr-whapi-offer-desc">
                                                <?php echo apply_filters( 'content', $offer->description ); ?>
                                            </div>

                                            <div class="ntr-whapi-offer-meta-wrap">
                                                <?php if( $offer->active_tod ) : ?>
                                                    <span class="eb-whoffers-meta-labels">
                                                        <?php _e( 'Book by: ', 'element-bits' ); ?>
                                                    </span>
                                                    <span class="ntr-whapi-offer-meta"><?php echo date_i18n( 'd M Y', strtotime( $offer->active_tod ) ); ?></span>
                                                <?php endif; ?>

                                                <?php if( $offer->fromd ) : ?>
                                                    <br>
                                                    <span class="eb-whoffers-meta-labels">
                                                        <?php _e( 'Stay period: ', 'element-bits' ); ?>
                                                    </span>
                                                    <span class="ntr-whapi-offer-meta">
                                                      <?php echo date_i18n( 'd M Y', strtotime( $offer->fromd ) ); ?> -
                                                      <?php echo date_i18n( 'd M Y', strtotime( $offer->tod ) ); ?>
                                                    </span>
                                                <?php endif; ?>

                                                <?php if( $offer->min_stay ) : ?>
                                                    <br>
                                                    <span class="eb-whoffers-meta-labels">
                                                        <?php _e( 'Minimum stay: ', 'element-bits' ); ?>
                                                    </span>
                                                    <span class="ntr-whapi-offer-meta">
                                                      <?php printf( _n( '%s night', '%s nights', $offer->min_stay, 'element-bits' ), $offer->min_stay ); ?>
                                                    </span>
                                                <?php endif; ?>

                                                <?php if( $offer->board_name ) : ?>
                                                    <br>
                                                    <span class="eb-whoffers-meta-labels">
                                                        <?php _e( 'Meal plan: ', 'element-bits' ); ?>
                                                    </span>
                                                    <span class="ntr-whapi-offer-meta"><?php echo esc_attr( $offer->board_name ); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="offer-price-wrap">
                                                <?php _e( 'From ', 'element-bits' ); ?>
                                                <span class="ntr-whapi-offer-price">&euro;<?php echo esc_attr( $offer->min_price ); ?></span>
                                                / <?php _e( 'per night ', 'element-bits' ); ?>
                                            </div>

                                            <div class="ntr-whapi-offer-footer">
                                                <a
                                                    href="<?php echo esc_url( $offer->bookurl ); ?>"
                                                    class="elementor-button ntr-whapi-offer-book-btn elementor-animation-<?php echo $settings['hover_animation']; ?>"
                                                    target="_blank">
                                                    <?php _e('BOOK NOW', 'element-bits'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    <?php else : ?>
                        <h3 class="ntr-whapi-offer-noresults"><?php _e( 'No offers are currently available', 'element-bits' ); ?></h3>
                    <?php endif; ?>

                </div>
            </div>
        <?php

    }

}
