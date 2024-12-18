<?php
namespace ElementBits\Widgets;

use \Elementor\Controls_Manager;
use \Entre\Elementor\Widgets\Widget_Base;
use \Elementor\Core\Files\File_Types\Svg;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class ACF_Gallery_Slides extends EB_Widget_Base {

    public function get_name() {
        return 'eb-acf-gallery-slides';
    }

    public function get_title() {
        return __( 'EB: ACF Gallery Slides', 'element-bits' );
    }

    public function get_keywords() {
        return [ 'slides', 'carousel', 'image', 'title', 'slider', 'acf', 'ntr', 'eb' ];
    }

    public function get_script_depends() {
        return [ 'imagesloaded', 'swiper' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => __( 'Slides', 'element-bits' ),
            ]
        );

        $this->add_control(
            'acf_key',
            [
                'label' => __( 'ACF Key', 'element-bits' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'container_height',
			[
				'label' => esc_html__( 'Slider Height', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem', 'vh' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 600,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-widget-swiper-container' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'next_prev_width',
			[
				'label' => esc_html__( 'Next/Prev width', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 600,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-next' => 'width: {{SIZE}}{{UNIT}}; border: none;',
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-prev' => 'width: {{SIZE}}{{UNIT}}; border: none;',
				],
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'next_prev_space_between',
			[
				'label' => esc_html__( 'Next/Prev space between', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-next' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-prev' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'next_prev_color',
			[
				'label' => esc_html__( 'Next/Prev Color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-prev' => 'color: {{VALUE}}',
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-next' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'next_prev_bg_color',
			[
				'label' => esc_html__( 'Next/Prev BG Color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-prev' => 'background: {{VALUE}}',
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-next' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'next_prev_padding',
			[
				'label' => esc_html__( 'Buttons padding', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .eb-widget-swiper-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eb-widget-swiper-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'next_prev_pos',
			[
				'label' => esc_html__( 'Next/Prev Alignment', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'element-bits' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'element-bits' ),
						'icon' => 'fa fa-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'element-bits' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .eb-widget-acf-gallery-slides-swiper-buttons' => 'justify-content: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-widget-swiper-overlay' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'section_icon_prev',
            [
                'label' => __( 'Previous Icon', 'element-bits' ),
            ]
        );

		$this->add_control(
			'icon_prev',
			[
				'label' => esc_html__( 'Prev Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_next',
            [
                'label' => __( 'Next Icon', 'element-bits' ),
            ]
        );

		$this->add_control(
			'icon_next',
			[
				'label' => esc_html__( 'Next Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => ['id' => 0, 'url' => get_template_directory() . '/assets/img/novel/long-arrow-r.svg'],
					'library' => 'svg',
				],
			]
		);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();


        if ( empty( $settings['acf_key'] ) ) {
            return;
        }

        $slides = \get_field( esc_attr( $settings['acf_key'] ) );

        if( ! $slides ) return;
        ?>
        <div class="eb-widget eb-widget-acf-gallery-slides-wrap">
            <div class="eb-widget-swiper eb-widget-acf-gallery-slides" style="width: 100%;">
                <div class="eb-widget-swiper-container swiper-container eb-widget-acf-gallery-slides-swiper-container">
					<div class="eb-widget-swiper-overlay"></div>
                    <!-- Additional required wrapper -->
                    <div class="eb-widget-swiper-wrapper swiper-wrapper eb-widget-acf-gallery-slides-swiper-wrapper">
                        <!-- Slides -->
                        <?php foreach( $slides as $i => $gallery_item ) : ?>
                            <div class="eb-widget-swiper-slide swiper-slide eb-widget-acf-gallery-slides-swiper-slide">
                                <img src="<?php echo esc_url( $gallery_item['sizes']['large'] ); ?>" alt="<?php the_title(); ?>"/>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pager buttons -->
                    <div class="eb-widget-swiper-buttons eb-widget-acf-gallery-slides-swiper-buttons">
                        <button class="eb-widget-swiper-prev eb-widget-acf-gallery-slides-swiper-prev <?php echo $settings['icon_prev']['library'] && $settings['icon_prev']['value'] ? '' : 'eb-widget-acf-gallery-slides-swiper-prev-rotate'; ?>">
							<?php if($settings['icon_prev']['library'] && $settings['icon_prev']['value'] && $settings['icon_prev']['library'] === 'svg') : ?>
									<?php echo file_get_contents($settings['icon_prev']['value']['url']); ?>
							<?php elseif($settings['icon_next']['library'] &&  $settings['icon_next']['value'] && $settings['icon_next']['library'] === 'svg') : ?>
								<?php echo file_get_contents($settings['icon_next']['value']['url']); ?>
							<?php else :  ?>
								next
							<?php endif; ?>
						</button>
                        <button class="eb-widget-swiper-next eb-widget-acf-gallery-slides-swiper-next">
							<?php if($settings['icon_next']['library'] && $settings['icon_next']['value'] && $settings['icon_next']['library'] === 'svg') : ?>
								<?php echo file_get_contents($settings['icon_next']['value']['url']); ?>
							<?php else :  ?>
								prev
							<?php endif; ?>
						</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            jQuery(document).ready(function($) {
                var ntrAcfGallerySwiper = new Swiper('.eb-widget-acf-gallery-slides-swiper-container', {
                    // Optional parameters
                    loop: true,
					effect: 'fade',
                    slidesPerView: 1,

                    // Navigation arrows
                    navigation: {
                        nextEl: '.eb-widget-acf-gallery-slides-swiper-next',
                        prevEl: '.eb-widget-acf-gallery-slides-swiper-prev',
                    },
                })
            })
        </script>
        <?php
    }
}
