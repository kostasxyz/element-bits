<?php
namespace ElementBits\Widgets;

use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;

defined( 'ABSPATH' ) || exit;

/**
 * Element bits section header.
 *
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.0
 * @version 1.1
 */
class EB_Heading extends EB_Widget_Base {

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
        return 'eb-heading';
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
        return __( 'EB: Heading', 'element-bits' );
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
        return [ 'novel', 'bits', 'header', 'eb', 'heading' ];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'heading_section',
            [
                'label' => __( 'Heading', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'element-bits' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'element-bits' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'element-bits' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-content' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => __( 'Heading', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => __( '', 'element-bits' ),
                'placeholder' => __( 'The Heading', 'element-bits' ),
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label' => __( 'Heading tag', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1'  => __( 'h1', 'element-bits' ),
                    'h2' => __( 'h2', 'element-bits' ),
                    'h3' => __( 'h3', 'element-bits' ),
                    'h4' => __( 'h4', 'element-bits' ),
                    'h5' => __( 'h5', 'element-bits' ),
                    'h6' => __( 'h6', 'element-bits' ),
                    'div' => __( 'div', 'element-bits' ),
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __( 'Heading Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-heading' => 'color: {{VALUE}}',
                ],
                'default' => '#222'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typo',
                'label' => __( 'Typography', 'element-bits' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .eb-heading-heading',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'head_shadow',
                'type' => 'text_shadow',
                'selector' => '{{WRAPPER}} .eb-heading-heading',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => __( 'Heading margin', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 120,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'element-bits' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'header_words_style',
            [
                'label' => __( 'Style heading words', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'header_word_to_style',
            [
                'label' => __( 'Text to colorize', 'element-bits' ),
                'description' => __( 'Enter a text potion from header to colorize', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( '', 'element-bits' ),
                'placeholder' => __( '', 'element-bits' ),
            ]
        );

        $this->add_control(
            'header_words_color',
            [
                'label' => __( 'Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-heading-part' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_words_typo',
                'label' => __( 'Typography', 'element-bits' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .eb-heading-heading-part',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'subheading_section',
            [
                'label' => __( 'Sub-Heading', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'subheading_pos',
            [
                'label' => __( 'Show Subheading above heading?', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'element-bits' ),
                'label_off' => __( 'No', 'element-bits' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'subheading_color',
            [
                'label' => __( 'SubHeading Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-subheading' => 'color: {{VALUE}}',
                ],
                'default' => '#222'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'subhead_shadow',
                'type' => 'text_shadow',
                'selector' => '{{WRAPPER}} .eb-heading-subheading',
            ]
        );

        $this->add_control(
            'subheading',
            [
                'label' => __( 'Sub-Heading', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => __( '', 'element-bits' ),
                'placeholder' => __( 'The Sub Heading', 'element-bits' ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subheading_typo',
                'type' => 'text_shadow',
                'label' => __( 'Typography', 'element-bits' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .eb-heading-subheading',
            ]
        );

        $this->add_responsive_control(
            'subheading_margin',
            [
                'label' => __( 'Sub-Heading margin', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 120,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-subheading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sep_section',
            [
                'label' => __( 'Separator line', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_sep',
            [
                'label' => __( 'Show Separator', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'sep_align',
            [
                'label' => __( 'Alignment', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'element-bits' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'element-bits' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'element-bits' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-sep' => 'justify-content: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'sep_bg',
            [
                'label' => __( 'Separator Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#222',
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-sep > span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'sep_width',
            [
                'label' => __( 'Separator width', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 700,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 320,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-sep > span' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'sep_height',
            [
                'label' => __( 'Separator height', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-sep > span' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sep_icon_section',
            [
                'label' => __( 'Icon', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_sep_icon',
            [
                'label' => __( 'Show Separator Icon', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'element-bits' ),
                'label_off' => __( 'Hide', 'element-bits' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

		$this->add_control(
			'sep_icon_pos',
			[
				'label' => __( 'Separator Icon Position', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'above_all',
				'options' => [
                    'above_all'  => __( 'Above all', 'element-bits' ),
                    'above_sep_line'  => __( 'Above sep line', 'element-bits' ),
					'below_all' => __( 'Below all', 'element-bits' ),
				],
			]
		);

		$this->add_control(
			'sep_icon',
			[
				'label' => __( 'Separator Icon?', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'solid',
				],
			]
        );

        $this->add_control(
            'sep_icon_bg',
            [
                'label' => __( 'Icon Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '#222',
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-sep-icon-wrapper' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_responsive_control(
			'sep_icon_size',
			[
				'label' => __( 'Icon Size', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 360,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 32,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-heading-sep-icon-wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'sep_icon_align',
            [
                'label' => __( 'Icon Alignment', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'element-bits' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'element-bits' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'element-bits' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eb-heading-sep-icon-wrapper' => 'text-align: {{VALUE}}',
                ]
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
        if( $settings['align'] === 'left') {
            $flex_align = 'flex-start';
        }
        elseif( $settings['align'] === 'right' ) {
            $flex_align = 'flex-end';
        }
        else {
            $flex_align = 'center';
        }

        if( $settings['header_word_to_style'] ) {
            $heading = str_ireplace(
                $settings['header_word_to_style'],
                '<span class="eb-heading-heading-part">'.$settings['header_word_to_style'].'</span>',
                $settings['heading']
            );
        }
        else {
            $heading = $settings['heading'];
        }

        $h_tag = $settings['heading_tag'] ?: 'h3';
        ?>
        <div class="eb-elementor-widget">
            <div class="eb-heading">
                <div class="eb-heading-content">
                    <?php if( $settings['show_sep_icon'] && $settings['sep_icon_pos'] === 'above_all' ) : ?>
                        <div class="eb-heading-sep-icon-wrapper eb-heading-sep-icon-wrapper-top">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['sep_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if( $settings['subheading'] && $settings['subheading_pos'] === 'yes' ) : ?>
                        <div class="eb-heading-subheading">
                            <?php echo wp_kses_post( $settings['subheading'] ); ?>
                        </div>
                    <?php endif; ?>

                    <<?php echo esc_attr( $h_tag ); ?> class="eb-heading-heading">
                        <?php echo wp_kses_post( $heading ); ?>
                    </<?php echo esc_attr( $h_tag ); ?>>

                    <?php if( $settings['subheading'] && $settings['subheading_pos'] !== 'yes' ) : ?>
                        <div class="eb-heading-subheading">
                            <?php echo wp_kses_post( $settings['subheading'] ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if( $settings['show_sep_icon'] && $settings['sep_icon_pos'] === 'above_sep_line' ) : ?>
                        <div class="eb-heading-sep-icon-wrapper eb-heading-sep-icon-wrapper-below_sep_line">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['sep_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if( $settings['show_sep'] ) : ?>
                        <div class="eb-heading-sep">
                            <span></span>
                        </div>
                    <?php endif; ?>

                    <?php if( $settings['show_sep_icon'] && $settings['sep_icon_pos'] === 'below_all' ) : ?>
                        <div class="eb-heading-sep-icon-wrapper eb-heading-sep-icon-wrapper-below_sep_line">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['sep_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php

    }
}
