<?php
namespace ElementBits\Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Element bits mobile nav.
 *
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.0
 * @version 1.1
 */
class EB_Nav_Drawer extends EB_Widget_Base {

    protected $nav_menu_index = 1;

    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
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
        return 'eb-nav-drawer';
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
        return __( 'EB: Nav Drawer', 'element-bits' );
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
        return [ 'novel', 'bits', 'eb', 'mobile', 'nav', 'drawer' ];
    }

    /**
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'eb-nav-drawer' ];
    }

    /**
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_style_depends() {
        return [ 'eb-nav-drawer' ];
    }

    /**
     * Get available wp menus
     *
     */
    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }

        return $options;
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
            'burger_style',
            [
                'label' => __( 'Burger Style', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'  => __( 'Style 1', 'element-bits' ),
                    '2'  => __( 'Style 2', 'element-bits' ),
                    '3'  => __( 'Style 3', 'element-bits' ),
                    '4'  => __( 'Style 4', 'element-bits' ),
                    '5'  => __( 'Style 5', 'element-bits' ),
                    '6'  => __( 'Style 6', 'element-bits' ),
                ],
            ]
        );

        $this->add_control(
            'burger_color',
            [
                'label' => __( 'Burger Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .eb-nav-toggle__line' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'burger_color_hover',
            [
                'label' => __( 'Burger Color (close)', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default' => '#444',
                'selectors' => [
                    '{{WRAPPER}} .eb-nav-toggle--open .eb-nav-toggle__line' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'burger_align',
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
                'default' => 'flex-end',
                'toggle' => true,
            ]
        );

		$this->add_control(
			'menu_tpl_id',
			[
				'label' => __( 'Template', 'element-bits' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $this->get_templates(),
			]
		);

        $this->end_controls_section();

    }

    /**
     * Get elementor templates
     *
     * @since 1.2
     * @return array $options
     */
    private function get_templates() {
        $tpls = get_posts(['post_type' => 'elementor_library', 'posts_per_page' => -1]);

        $options = ['' => ''];

        if( $tpls ) {
            foreach( $tpls as $tpl ) {
                $options[$tpl->ID] = $tpl->post_title;
            }
        }

        return $options;
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

        $sets = $this->get_settings_for_display();

        $args = [
            'echo' => false,
            'menu' => isset( $sets['menu'] ) ? $sets['menu'] : 0,
            'menu_class' => 'eb-mobile-nav-menu',
            'menu_id' => 'eb-mobile-nav-menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'fallback_cb' => '__return_empty_string',
            'container' => '',
        ];

        // General Menu.
        $menu_html = wp_nav_menu( $args );
        ?>
            <div class="eb-nav-toggle-wrap" style="justify-content: <?php echo esc_attr( $sets['burger_align'] ); ?>">
                <div
                    class="eb-nav-toggle eb-nav-toggle--x-<?php echo esc_attr( $sets['burger_style'] ); ?> ebjs-nav-toggle">
                    <div class="eb-nav-toggle__lines">
                        <div class="eb-nav-toggle__line eb-nav-toggle__line--1"></div>
                        <div class="eb-nav-toggle__line eb-nav-toggle__line--2"></div>
                        <div class="eb-nav-toggle__line eb-nav-toggle__line--3"></div>
                        <?php if( $sets['burger_style'] === '5' ) : ?>
                            <div class="eb-nav-toggle__line eb-nav-toggle__line--4"></div>
                            <div class="eb-nav-toggle__line eb-nav-toggle__line--5"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="eb-mobile-nav-wrap" id="eb-mobile-nav-wrap-<?php echo $this->get_id(); ?>">
                <div class="eb-mobile-nav-content">
                    <?php
                    // TODO: Check if do_shortcode is best practise
                    if( 'publish' === get_post_status( $sets['menu_tpl_id'] ) ) :
                    ?>
                        <?php echo do_shortcode('[elementor-template id="'.(int)$sets['menu_tpl_id'].'"]'); ?>
                    <?php else : ?>
                        <p>Create a template for the mobile menu and asign it here</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php

    }
}
