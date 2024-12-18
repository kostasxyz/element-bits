<?php
/**
 * Plugin Name: Element Bits
 * Description: Extra Elementor Widgets
 * Plugin URI: https://noveldigital.pro
 * Author: Kostas Charalampidis
 * Version: 1.2
 * Author URI: https://noveldigital.pro
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
    define( 'ELBITS_VERSION', '1.2' );
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

    // Check Elementor version
    if ( ! version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) {
        add_action( 'admin_notices', function() {
            $message = sprintf(
                esc_html__( 'Element Bits requires Elementor version %s or greater. Please update Elementor to continue.', 'element-bits' ),
                '3.5.0'
            );
            $html = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
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
    add_action( 'elementor/dynamic_tags/register', function( $dynamic_tags ) {
        \Elementor\Plugin::$instance->dynamic_tags->register_group( 'eb-dynamic-tags', [
            'title' => 'ElementBits'
        ] );

        // Include the Dynamic tag class file
        include_once ELBITS_PATH . 'dynamic-tags/dynamic-tags.php';

        // Register the tag
        // $dynamic_tags->register( new \ElementBits\Tags\Site_Logo );
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
        require ELBITS_PATH . 'widgets/eb-novel-powered.php';
        require ELBITS_PATH . 'widgets/eb-acf-repeater-list.php';
        require ELBITS_PATH . 'widgets/eb-acf-gallery-slides.php';
    } );

    // Register widgets
    add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
        $widgets_manager->register( new \ElementBits\Widgets\EB_Heading() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_Accordion_Wp_Menu() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_Wpml_Lang_Switch() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_Vertical_Sep() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_Whapi_Offers() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_WH_Datepicker() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_Menu_Icon_Button() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_Google_Map() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_Image_Hover() );
        $widgets_manager->register( new \ElementBits\Widgets\EB_Weather() );
        $widgets_manager->register( new \ElementBits\Widgets\Novel_Powered() );
        $widgets_manager->register( new \ElementBits\Widgets\ACF_Repeater_List_Widget() );
        $widgets_manager->register( new \ElementBits\Widgets\ACF_Gallery_Slides() );
    } );

    // Front end scripts/styles
    add_action('wp_enqueue_scripts', function() use ($settings) {
        // Core styles
        wp_enqueue_style('element-bits', ELBITS_URL . 'assets/css/element-bits.css', [], ELBITS_VERSION);

        // Third party dependencies
        wp_register_style('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', [], ELBITS_VERSION);
        wp_register_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', [], ELBITS_VERSION, true);

        // Widget specific styles
        wp_register_style('weather-icons', ELBITS_URL . 'assets/css/weather-icons.css', ['element-bits'], ELBITS_VERSION);
        wp_register_style('eb-menu-icon-button', ELBITS_URL . 'assets/css/eb-menu-icon-button.css', ['element-bits'], ELBITS_VERSION);

        // Core script - load after Elementor
        wp_enqueue_script('element-bits', ELBITS_URL . 'assets/js/element-bits.js', ['jquery', 'elementor-frontend'], ELBITS_VERSION, true);

        // Localize script
        wp_localize_script('element-bits', 'ebits', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('element-bits-nonce'),
            'pluginUrl' => ELBITS_URL
        ]);

        // Register widget scripts
        $widget_scripts = [
            'eb-accordion-menu' => ['jquery', 'element-bits'],
            'eb-wh-datepicker' => ['jquery', 'flatpickr', 'element-bits'],
            'eb-wpml-lang-switch' => ['jquery', 'element-bits'],
            'eb-google-map' => ['jquery', 'element-bits'],
            'eb-weather' => ['jquery', 'element-bits']
        ];

        foreach ($widget_scripts as $handle => $deps) {
            wp_register_script(
                $handle,
                ELBITS_URL . "assets/js/{$handle}.js",
                $deps,
                ELBITS_VERSION,
                true
            );
        }

        // Google Maps API (if key exists)
        if ($gmap_api_key = $settings->options('gmap_key')) {
            wp_enqueue_script('googleapis-maps',
                'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($gmap_api_key),
                [],
                null,
                true
            );
        }
    }, 20);

    // Handle AJAX requests
    add_action('wp_ajax_eb_ajax_request', function() {
        check_ajax_referer('element-bits-nonce', 'nonce');

        $action = isset($_POST['eb_action']) ? sanitize_text_field($_POST['eb_action']) : '';
        $response = ['success' => false];

        switch ($action) {
            case 'weather_data':
                // Handle weather data request
                break;
            // Add other cases as needed
        }

        wp_send_json($response);
    });

    add_action('wp_ajax_nopriv_eb_ajax_request', function() {
        check_ajax_referer('element-bits-nonce', 'nonce');
        wp_send_json(['success' => false, 'message' => 'Login required']);
    });

    // Preview styles
    add_action( 'elementor/editor/before_enqueue_scripts', function() {
        wp_enqueue_style( 'element-bits', ELBITS_URL . 'assets/css/admin.css', [], ELBITS_VERSION );
    } );

    add_action( 'admin_enqueue_scripts', function() {
        wp_enqueue_style( 'element-bits', ELBITS_URL . 'assets/css/admin.css', [], ELBITS_VERSION );
    } );
}
