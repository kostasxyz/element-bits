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
class ACF_Repeater_List_Widget extends EB_Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    }

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
        return 'eb-acf-repeater-list';
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
        return __( 'EB: ACF Repeater List', 'element-bits' );
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
        return [ 'entre', 'widget', 'acf', 'eb' ];
    }

    public function get_script_depends() {
        return [];
    }

    public function get_style_depends() {
        return [];
    }


    private function register_control_content_section() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'element-bits' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'acf_repeater',
			[
				'label' => __( 'Repeater', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => $this->get_acf_repeater_options()['repeaters'],
			]
		);

		$this->add_control(
			'acf_subfield1',
			[
				'label' => __( 'Repeater field 1', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => $this->get_acf_repeater_options()['subfields'],
                'condition' => [
                    'acf_repeater!' => 'none',
                ]
			]
		);

		$this->add_control(
			'acf_subfield2',
			[
				'label' => __( 'Repeater field 2', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => $this->get_acf_repeater_options()['subfields'],
                'condition' => [
                    'acf_repeater!' => 'none',
                ]
			]
		);

		$this->add_control(
			'list_columns',
			[
				'label' => esc_html__( 'Columns', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'row_align',
			[
				'label' => esc_html__( 'Column Align', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => [
					'flex-start'  => esc_html__( 'Top', 'element-bits' ),
					'center' => esc_html__( 'Center', 'element-bits' ),
					'flex-end' => esc_html__( 'Bottom', 'element-bits' ),
				],
                'selectors' => [
                    '{{WRAPPER}} .eb-acf-repeater-list-widget-rows' => 'align-items: {{VALUE}}',
                ],
			]
		);

		$this->add_control(
			'row_justify',
			[
				'label' => esc_html__( 'Column Jusitfy', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => [
					'flex-start'  => esc_html__( 'Left', 'element-bits' ),
					'center' => esc_html__( 'Center', 'element-bits' ),
					'flex-end' => esc_html__( 'Right', 'element-bits' ),
					'space-between' => esc_html__( 'Between', 'element-bits' ),
					'space-around' => esc_html__( 'Around', 'element-bits' ),
				],
                'selectors' => [
                    '{{WRAPPER}} .eb-acf-repeater-list-widget-rows' => 'justify-content: {{VALUE}}',
                ],
			]
		);

        $this->end_controls_section();
    }

    private function register_control_style_section_column() {
		$this->start_controls_section(
			'section_style_column',
			[
				'label' => __( 'List', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_responsive_control(
			'ul_padding',
			[
				'label' => esc_html__( 'List padding', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default' => [
					'unit' => 'rem',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-acf-repeater-list-widget-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ul_margin',
			[
				'label' => esc_html__( 'List margin', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default' => [
					'unit' => 'rem',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-acf-repeater-list-widget-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'ul_background',
				'label' => esc_html__( 'Background', 'element-bits' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .eb-acf-repeater-list-widget-list',
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'list_border',
				'selector' => '{{WRAPPER}} .eb-acf-repeater-list-widget-list',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ul_border_radius',
			[
				'label' => esc_html__( 'List Border radius', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-acf-repeater-list-widget-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'ul_shadow',
				'label' => esc_html__( 'List Shadow', 'element-bits' ),
				'selector' => '{{WRAPPER}} .eb-acf-repeater-list-widget-list',
			]
		);

        $this->end_controls_section();
    }

    private function register_control_style_section_icon() {
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-minus',
					'library' => 'solid',
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
            'icon_color',
            [
                'label' => __( 'Icon Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#111',
                'selectors' => [
                    '{{WRAPPER}} .eb-acf-repeater-list-widget-icon' => 'color: {{VALUE}}',
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
            'align_icon',
            [
                'label' => __( 'Align Icon', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __( 'Left', 'element-bits' ),
                    'right'   => __( 'Right', 'element-bits' ),
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
			'icon_margin',
			[
				'label' => __( 'Icon margin', 'element-bits' ),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
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
			'icon_size',
			[
				'label' => __( 'Icon Size', 'element-bits' ),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'rem' => [
						'min' => 0,
						'max' => 200,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'rem',
					'size' => 1,
				],
                'selectors' => [
                    '{{WRAPPER}} .eb-acf-repeater-list-widget-icon' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .eb-acf-repeater-list-widget-icon svg' => 'width: 100%',
                ],
			]
		);

        $this->end_controls_section();
    }

    private function register_control_style_section_text_typo() {
		$this->start_controls_section(
			'section_style_text_typo',
			[
				'label' => __( 'Text', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#111',
                'selectors' => [
                    '{{WRAPPER}} .eb-acf-repeater-list-widget-text' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typo',
                'label' => __( 'Text Typography', 'element-bits' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-acf-repeater-list-widget-text',
            ]
        );

        $this->end_controls_section();
    }

    private function register_control_style_section_subtext_typo() {
		$this->start_controls_section(
			'section_style_subtext_typo',
			[
				'label' => __( 'Subtext', 'element-bits' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
            'subtext_color',
            [
                'label' => __( 'Subtext Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'default' => '#111',
                'selectors' => [
                    '{{WRAPPER}} .eb-acf-repeater-list-widget-subtext' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'_' . rand(10000000,99999999),
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtext_typo',
                'label' => __( 'Subtext Typography', 'element-bits' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-acf-repeater-list-widget-subtext',
            ]
        );

        $this->end_controls_section();
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

        $this->register_control_content_section();
        $this->register_control_style_section_column();
        $this->register_control_style_section_icon();
        $this->register_control_style_section_text_typo();
        $this->register_control_style_section_subtext_typo();

    }

    private function get_acf_repeater_options() {

        $repeaters = [
            'repeaters' => ['none' => '...'],
            'subfields' => ['none' => '...'],
        ];

        if ( ! function_exists( '' ) ) {
            return $repeaters;
        }

        if( $fields = get_field_objects() ) {
            foreach( $fields as $field ) {
                if( $field['type'] === 'repeater' ) {
                    $repeaters['repeaters'][$field['name']] = $field['label'];

                    foreach( $field['sub_fields'] as $sub ) {
                        $repeaters['subfields'][$sub['name']] = $sub['label'].' ('.$field['label'].')';
                    }
                }
            }
        }

        return $repeaters;
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
        $pid = get_the_ID();
        $css_base_class = 'eb-acf-repeater-list-widget';
        $columns = absint( $settings['list_columns'] );


        $repeater_rows = [];
        if( $repeater_field = get_field( $settings['acf_repeater'] ) ) {
            $repeater_rows = array_chunk(
                $repeater_field,
                absint(
                    ceil(
                        count( $repeater_field ) / $columns
                    )
                )
            );
        }


        $this->add_render_attribute('icon_wrap', [
			'class' => [$css_base_class . '-icon'],
			'style' => [
                'display: flex; align-items: center;',
                'margin-' . ($settings['align_icon'] === 'right' ? 'left' : 'right') . ': ' . $settings['icon_margin']['size'].$settings['icon_margin']['unit'] . ';',
            ],
		] );

        $this->add_render_attribute('ul', [
			'class' => [$css_base_class . '-list'],
			'style' => [
                'list-style-type: none',
            ],
		] );

        $this->add_render_attribute('list_item', [
			'class' => [$css_base_class . '-list-item'],
			'style' => [
                'display: flex;',
                'align-items: center;',
                'flex-direction: ' . ($settings['align_icon'] === 'right' ? 'row-reverse;' : 'row;'),
            ],
		] );

        $this->add_render_attribute('text', [
			'class' => [$css_base_class . '-text'],
			'style' => [
                'margin-right: 5px',
            ],
		] );
        ?>
            <div class="eb-widget-wrapper <?php echo $css_base_class; ?>-wrapper">
                <div style="display: flex;" class="<?php echo $css_base_class; ?>-rows">
                    <?php if( !empty( $repeater_rows ) && $settings['acf_subfield1'] !==  'none' ) : ?>
                        <?php foreach( $repeater_rows as $row ) : ?>
                            <ul <?php echo $this->get_render_attribute_string( 'ul' ); ?>>
                                <?php foreach( $row as $field ) : ?>
                                    <li <?php echo $this->get_render_attribute_string( 'list_item' ); ?>>
                                        <span <?php echo $this->get_render_attribute_string( 'icon_wrap' ); ?>>
                                            <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        </span>
                                        <span <?php echo $this->get_render_attribute_string( 'text' ); ?>>
                                            <?php echo esc_attr( $field[$settings['acf_subfield1']] ); echo $columns; ?>
                                        </span>
                                        <?php if( $settings['acf_subfield2'] !==  'none' ) : ?>
                                            <span class="<?php echo $css_base_class; ?>-subtext"> <?php echo esc_attr( $field[$settings['acf_subfield2']] ); ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php

    }

}
