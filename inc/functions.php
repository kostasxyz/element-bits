<?php
defined( 'ABSPATH' ) || exit;

/**
 * Add responsive visibility for
 * Elementor colums
 *
 * @version 1.2.1
 */
if ( !function_exists( 'ntr_hide_column_elementor_controls' ) ) :
function ntr_hide_column_elementor_controls( $section, $section_id, $args ) {
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

add_action( 'elementor/element/before_section_end' , 'ntr_hide_column_elementor_controls', 10, 3 );
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
        return rand(1, 10000000000000);
    }

    if( file_exists( ELBITS_PATH . $path ) ) {
        return filemtime( ELBITS_PATH . $path );
    }

    return null;
}
