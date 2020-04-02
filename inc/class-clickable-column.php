<?php
namespace ElementBits;

defined( 'ABSPATH' ) || exit;

/**
 * Main Class
 *
 * @author   Kostasc <skapator@gmail.com>
 * @since    1.0.4
 * @package  ElementBits
 */
class Clickable_Column {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'public_scripts' ] );
        add_action( 'elementor/element/column/layout/before_section_end', [ $this, 'extend_widget' ], 10, 2 );
        add_action( 'elementor/frontend/column/before_render', [ $this, 'before_render_options' ], 10 );
    }

    /**
     * After layout callback
     *
     * @param  object $element
     * @param  array $args
     * @return void
     */
    public function extend_widget( $element, $args ) {
        $element->add_control(
            'column_link',
            [
                'label'       => __( 'Link', 'element-bits' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://your-link.com', 'elementor' ),
                'selectors'   => [
                ],
            ]
        );
    }


    public function before_render_options( $element ) {
      $settings  = $element->get_settings_for_display();

      if ( isset( $settings['column_link'], $settings['column_link']['url'] ) && ! empty( $settings['column_link']['url'] ) ) {
        wp_enqueue_script( 'eb-clickable-column' );

        $element->add_render_attribute( '_wrapper', 'class', 'eb-clickable-column' );
        $element->add_render_attribute( '_wrapper', 'style', 'cursor: pointer;' );
        $element->add_render_attribute( '_wrapper', 'data-eb-col-clickable-url', $settings['column_link']['url'] );
        $element->add_render_attribute( '_wrapper', 'data-eb-col-clickable-target', $settings['column_link']['is_external'] ? '_blank' : '_self' );

        if( $settings['column_link']['nofollow'] ) {
            $element->add_render_attribute( '_wrapper', 'data-eb-col-clickable-rel', 'nofollow' );
        }
      }
    }


    public function public_scripts() {
      wp_register_script( 'eb-clickable-column', ELBITS_URL . 'assets/js/clickable-column.js', ['jquery'], ELBITS_VERSION, true );
    }
  }
