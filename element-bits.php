<?php
/**
 * Plugin Name: Element Bits
 * Description: Extra Elementor Widgets
 * Plugin URI: https://noveldigital.pro
 * Author: Kostas Charalampidis
 * Version: 1.0
 * Author URI: https://code42.xyz
 *
 * Text Domain: element-bits
 *
 * @package Element_Bits
 *
 * Element Bits is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Element Bits is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'plugins_loaded', 'elbits_init' );

/**
 * Element bits
 *
 * @todo Add novel signature svg in dynamic tag
 */
function elbits_init() {
    // Plugin paths/uri
    define( 'ELBITS_VERSION', '1.0.4' );
    define( 'ELBITS_URL', plugins_url( '/', __FILE__ ) );
    define( 'ELBITS_PATH', plugin_dir_path( __FILE__ ) );

    // Check for elementor plugin
    if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', function() {
            $message   = esc_html__( 'Element Bits requires the Elementor page builder to be active. Please activate Elementor to continue.', 'element-bits' );
            $html      = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
            echo wp_kses_post( $html );
        } );

		return;
    }

    // PHP version check
    if ( ! version_compare( PHP_VERSION, '7', '>=' ) ) {
		add_action( 'admin_notices', function() {
            $message   = esc_html__( 'Element Bits requires PHP version 7.0+, the plugin is currently NOT ACTIVE.', 'element-bits' );
            $html      = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
            echo wp_kses_post( $html );
        } );

		return;
    }

    // Settings init
    require 'inc/settings.php';
    $settings = new \ElementBits\Settings;

    // Helper functions
    require ELBITS_PATH . 'inc/functions.php';

    // Make columns clickable
    require ELBITS_PATH . 'inc/class-clickable-column.php';
    new \ElementBits\Clickable_Column();

    // Register custom dynamic tags
    add_action( 'elementor/dynamic_tags/register_tags', function( $dynamic_tags ) {
        \Elementor\Plugin::$instance->dynamic_tags->register_group( 'eb-dynamic-tags', [
            'title' => 'ElementBits'
        ] );

        // Include the Dynamic tag class file
        include_once ELBITS_PATH . 'dynamic-tags/dynamic-tags.php';

        // Register the tag
        // $dynamic_tags->register_tag( '\ElementBits\Tags\Site_Logo' );
    } );

    // Add widgets
    add_action( 'elementor/init', function() {

        // Add element bits widget category
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'element-bits',
            [
                'title' => __( 'Element Bits', 'element-bits' ),
                'icon'  => 'font',
            ]
        );

        // Include widgets
        require ELBITS_PATH . 'widgets/eb-widget-base.php';
        require ELBITS_PATH . 'widgets/eb-heading.php';
        require ELBITS_PATH . 'widgets/eb-accordion-menu.php';
        require ELBITS_PATH . 'widgets/eb-wpml-lang-switch.php';
        require ELBITS_PATH . 'widgets/eb-vertical-sep.php';
        require ELBITS_PATH . 'widgets/eb-whapi-offers.php';
        require ELBITS_PATH . 'widgets/eb-wh-datepicker.php';
        require ELBITS_PATH . 'widgets/eb-menu-icon-button.php';
        require ELBITS_PATH . 'widgets/eb-google-map.php';
        require ELBITS_PATH . 'widgets/eb-image-hover.php';
        require ELBITS_PATH . 'widgets/eb-weather.php';
    } );

    // Register widgets
    add_action( 'elementor/widgets/widgets_registered', function ( $widgets_manager ) {
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Heading() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Accordion_Wp_Menu() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Wpml_Lang_Switch() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Vertical_Sep() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Whapi_Offers() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_WH_Datepicker() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Menu_Icon_Button() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Google_Map() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Image_Hover() );
        $widgets_manager->register_widget_type( new \ElementBits\Widgets\EB_Weather() );
    } );

    // Front end scripts/styles
    add_action( 'wp_enqueue_scripts', function() use ( $settings ) {
		wp_enqueue_style( 'element-bits', ELBITS_URL . 'assets/css/element-bits.css', [], ELBITS_VERSION );
        wp_enqueue_script( 'element-bits', ELBITS_URL . 'assets/js/element-bits.js', [ 'jquery' ], ELBITS_VERSION, true );

        wp_register_script( 'eb-accordion-menu', ELBITS_URL . 'assets/js/eb-accordion-menu.js', ['element-bits'], ELBITS_VERSION);

        wp_register_script( 'eb-weather', ELBITS_URL . 'assets/js/eb-weather.js', ['element-bits'], ELBITS_VERSION);
        wp_register_style( 'weather-icons', ELBITS_URL . 'assets/css/weather-icons.css', [ 'element-bits' ], ELBITS_VERSION );

        wp_register_script( 'tingle', ELBITS_URL . 'assets/vendor/tingle/tingle.min.js', [], ELBITS_VERSION);
        wp_register_style( 'tingle', ELBITS_URL . 'assets/vendor/tingle/tingle.min.css', [ 'element-bits' ], ELBITS_VERSION );
        wp_register_script( 'eb-wpml-lang-switch', ELBITS_URL . 'assets/js/eb-wpml-lang-switch.js', ['tingle'], ELBITS_VERSION);

        wp_register_style( 'eb-menu-icon-button', ELBITS_URL . 'assets/css/eb-menu-icon-button.css', [ 'element-bits' ], ELBITS_VERSION );

        wp_register_style( 'flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', [], ELBITS_VERSION );
        // wp_register_style( 'flatpickr-theme', 'https://npmcdn.com/flatpickr/dist/themes/airbnb.css', ['flatpickr'], ELBITS_VERSION );
        wp_register_script( 'flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', [], ELBITS_VERSION, true );

        wp_register_script( 'eb-wh-datepicker', ELBITS_URL . 'assets/js/eb-wh-datepicker.js', [ 'jquery', 'flatpickr' ], ELBITS_VERSION, true );

        wp_enqueue_script( 'eb-google-map', ELBITS_URL . 'assets/js/eb-google-map.js', [ 'element-bits' ], ELBITS_VERSION, true );

        // wp_register_style( 'leaflet', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.css', [ 'element-bits' ], null );
        // wp_register_script( 'leaflet', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.js', [ 'element-bits' ], null, true );

        if( $gmap_api_key = $settings->options( 'gmap_key' ) ) {
            wp_enqueue_script( 'googleapis-maps', 'https://maps.googleapis.com/maps/api/js?key=' . esc_attr( $gmap_api_key ), [], null, false );
        }
    } );

    // Preview styles
    add_action( 'elementor/editor/before_enqueue_scripts', function() {
        wp_enqueue_style( 'element-bits', ELBITS_URL . 'assets/css/admin.css', [], ELBITS_VERSION );
    } );

    add_action( 'admin_enqueue_scripts', function() {
        wp_enqueue_style( 'element-bits', ELBITS_URL . 'assets/css/admin.css', [], ELBITS_VERSION );
    } );
}
