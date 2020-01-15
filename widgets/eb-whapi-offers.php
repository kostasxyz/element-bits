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
    private function dummy_offers() {
        $offer = new \stdClass();
        $offer->id = 123;
        $offer->name = 'Sample offer 20% off | Please enter WebHotelier API keys';
        $offer->fromd = '2029-01-01';
        $offer->tod = '2029-12-31';
        $offer->active_tod = '2029-01-01';
        $offer->active_fromd = '2029-12-31';
        $offer->description = 'Please enter WebHotelier API keys. Book now and Save up to 25%. PLUS Meals, Festivities, Free Room Upgrades and Late Check-out all included. Book Now.';
        $offer->min_price = '199.88';
        $offer->currency = 'EUR';
        $offer->min_stay = 3;
        $offer->board_id = 19;
        $offer->board_name = 'Breakfast';
        $offer->adults = 2;
        $offer->children = 0;
        $offer->infants = 0;
        $offer->photourl = 'http://lorempixel.com/90/60/nature/';
        $offer->photourlS = 'http://lorempixel.com/90/60/nature/';
        $offer->photourlM = 'http://lorempixel.com/390/250/nature/';
        $offer->photourlL = 'http://lorempixel.com/1920/720/nature/';
        $offer->bookurl = 'https://example.com';
        $offer->display = 1;

        return [
            $offer,
            $offer,
            $offer
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
                'label' => __( 'API keys', 'element-bits' ),
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
                                                    <?php _e( 'Book by: ', 'whapi_offers' ); ?>
                                                    <span class="ntr-whapi-offer-meta"><?php echo date_i18n( 'd M Y', strtotime( $offer->active_tod ) ); ?></span>
                                                <?php endif; ?>

                                                <?php if( $offer->fromd ) : ?>
                                                    <br>
                                                    <?php _e( 'Stay period: ', 'whapi_offers' ); ?>
                                                    <span class="ntr-whapi-offer-meta">
                                              <?php echo date_i18n( 'd M Y', strtotime( $offer->fromd ) ); ?> -
                                              <?php echo date_i18n( 'd M Y', strtotime( $offer->tod ) ); ?>
                                            </span>
                                                <?php endif; ?>

                                                <?php if( $offer->min_stay ) : ?>
                                                    <br>
                                                    <?php _e( 'Stay period: ', 'whapi_offers' ); ?>
                                                    <span class="ntr-whapi-offer-meta">
                                              <?php printf( _n( '%s night', '%s nights', $offer->min_stay, 'whapi_offers' ), $offer->min_stay ); ?>
                                            </span>
                                                <?php endif; ?>

                                                <?php if( $offer->board_name ) : ?>
                                                    <br>
                                                    <?php _e( 'Meal plan: ', 'whapi_offers' ); ?>
                                                    <span class="ntr-whapi-offer-meta"><?php echo esc_attr( $offer->board_name ); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="offer-price-wrap">
                                                <?php _e( 'From ', 'whapi_offers' ); ?>
                                                <span class="ntr-whapi-offer-price">&euro;<?php echo esc_attr( $offer->min_price ); ?></span>
                                                / <?php _e( 'per night ', 'whapi_offers' ); ?>
                                            </div>

                                            <div class="ntr-whapi-offer-footer">
                                                <a href="<?php echo esc_url( $offer->bookurl ); ?>" class="ntr-whapi-offer-book-btn" target="_blank">
                                                    <?php _e('BOOK NOW', 'whapi_offers'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    <?php else : ?>
                        <h3 class="ntr-whapi-offer-noresults"><?php _e( 'No offers are currently available', 'whapi_offers' ); ?></h3>
                    <?php endif; ?>

                </div>
            </div>
        <?php

    }

}
