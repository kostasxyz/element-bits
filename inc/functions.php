<?php
defined( 'ABSPATH' ) || exit;

/**
 * Add responsive visibility for
 * Elementor colums
 *
 * @version 1.2.1
 */
if ( !function_exists( 'elbits_hide_column_elementor_controls' ) ) :
function elbits_hide_column_elementor_controls( $section, $section_id, $args ) {
    if( $section_id == 'section_advanced' ) {

        $section->add_control(
            'hide_desktop_column',
            [
                'label'        => __( 'Hide On Desktop', 'elementor' ),
                'type'         => Elementor\Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'elementor-',
                'label_on'     => __( 'Hide', 'elementor' ),
                'label_off'    => __( 'Show', 'elementor' ),
                'return_value' => 'hidden-desktop',
            ]
        );

        $section->add_control(
            'hide_tablet_column',
            [
                'label'        => __( 'Hide On Tablet', 'elementor' ),
                'type'         => Elementor\Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'elementor-',
                'label_on'     => __( 'Hide', 'elementor' ),
                'label_off'    => __( 'Show', 'elementor' ),
                'return_value' => 'hidden-tablet',
            ]
        );

        $section->add_control(
            'hide_mobile_column',
            [
                'label'        => __( 'Hide On Mobile', 'elementor' ),
                'type'         => Elementor\Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'elementor-',
                'label_on'     => __( 'Hide', 'elementor' ),
                'label_off'    => __( 'Show', 'elementor' ),
                'return_value' => 'hidden-phone',
            ]
        );
    }
}

add_action( 'elementor/element/before_section_end' , 'elbits_hide_column_elementor_controls', 10, 3 );
endif;

/**
 * Get filetime
 *
 * @param string $path The path to the file
 * @version 1.0
 * @return int
 */
function elbits_filetime( $path, $random_version = false ) {

    if( $random_version ) {
        return rand(1, 100000000000001);
    }

    if( file_exists( ELBITS_PATH . $path ) ) {
        return filemtime( ELBITS_PATH . $path );
    }

    return null;
}

/**
 * WH offers refresh
 *
 */
add_action( 'rest_api_init', function () {
    register_rest_route( 'elbits/v1', '/whapi/offers/refresh', array(
        'methods' => 'GET',
        'callback' => 'elbits_whapi_offers_refresh',
        'permission_callback' => '__return_true'
    ) );
} );

function elbits_whapi_offers_refresh() {

    $langs = apply_filters( 'wpml_active_languages', null, ['skip_missing' => 0]);

    if( $langs ) {
        foreach( $langs as $lang ) {
            delete_transient( 'entre_whapi_offers_' . $lang );
        }
    }

    wp_redirect( site_url( '/' ) );

    die();
}

// Function that outputs the contents of the dashboard widget
function entre_refresh_whapi_offers_dashboard_widget_cb( $post, $callback_args ) {
    echo '<p>If you have updated your offer on web hotelier and the changes are not reflected on the site, click this button to make a hard refresh.</p>';
    echo '<p>Please make sure you have updated correctly your offer on web hotelier.</p>';
    echo '<a href="/wp-json/elbits/v1/whapi/offers/refresh" class="button button-primary button-large" target="_blank">Refresh WebHotelier Offers</a>';
}

// Function used in the action hook
function entre_add_dashboard_widgets() {
    wp_add_dashboard_widget('entre_refresh_whapi_offers_dashboard_widget', 'Refresh WebHotelier Offers', 'entre_refresh_whapi_offers_dashboard_widget_cb');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'entre_add_dashboard_widgets' );
