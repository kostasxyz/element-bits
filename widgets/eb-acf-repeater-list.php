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
        return [ 'entre', 'widget' ];
    }

    public function get_script_depends() {
        return [];
    }

    public function get_style_depends() {
        return [];
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

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Field 1 Color', 'element-bits' ),
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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'Typography',
                'label' => __( 'Field 1 Typography', 'element-bits' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-acf-repeater-list-widget-text',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Field 1 Color', 'element-bits' ),
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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'Typography',
                'label' => __( 'Field 2 Typography', 'element-bits' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eb-acf-repeater-list-widget-subtext',
            ]
        );

        $this->end_controls_section();

    }

    private function get_acf_repeater_options() {
        $fields = get_field_objects();
        $repeaters = [
            'repeaters' => ['none' => '...'],
            'subfields' => ['none' => '...'],
        ];

        foreach( $fields as $field ) {
            if( $field['type'] === 'repeater' ) {
                $repeaters['repeaters'][$field['name']] = $field['label'];

                foreach( $field['sub_fields'] as $sub ) {
                    $repeaters['subfields'][$sub['name']] = $sub['label'].' ('.$field['label'].')';
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

        $this->add_render_attribute('icon_wrap', [
			'class' => [$css_base_class . '-icon'],
			'style' => [
                'display: flex; align-items: center;',
                'margin-' . ($settings['align_icon'] === 'right' ? 'left' : 'right') . ': ' . $settings['icon_margin']['size'].$settings['icon_margin']['unit'] . ';',
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
        ?>
            <div class="eb-widget-wrapper <?php echo $css_base_class; ?>-wrapper">
                <?php if( $settings['acf_repeater'] !== 'none' && $settings['acf_subfield1'] !==  'none' ) : ?>
                    <ul class="<?php echo $css_base_class; ?>-list">
                    <?php $repeater = get_field( $settings['acf_repeater'] ); ?>
                        <?php foreach( $repeater as $field ) : ?>
                            <li <?php echo $this->get_render_attribute_string( 'list_item' ); ?>>
                                <span <?php echo $this->get_render_attribute_string( 'icon_wrap' ); ?>>
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </span>
                                <span class="<?php echo $css_base_class; ?>-text"><?php echo esc_attr( $field[$settings['acf_subfield1']] ); ?></span>
                                <?php if( $settings['acf_subfield2'] !==  'none' ) : ?>
                                    <span class="<?php echo $css_base_class; ?>-subtext"><?php echo esc_attr( $field[$settings['acf_subfield2']] ); ?></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php

    }

}
