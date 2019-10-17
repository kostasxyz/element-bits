<?php
namespace ElementBits\Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Element bits wpml lang switch popup.
 *
 * @todo Fix styling options
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.0
 * @version 1.1
 */
class EB_Wpml_Lang_Switch extends EB_Widget_Base {

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
        return 'eb-wpml-lang-switch';
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
        return __( 'EB: Wpml Lang Switch', 'element-bits' );
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
        return [ 'novel', 'bits', 'wpml', 'switch', 'eb' ];
    }

    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'tinglejs', 'eb-widget-wpml-lang-switch' ];
    }

    /**
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_style_depends() {
        return [ 'tinglejs', 'eb-elements' ];
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
            'display_content',
            [
                'label' => __( 'Display type', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'switch_popup',
                'options' => [
                    'switch_popup'  => __( 'Switch and popup', 'element-bits' ),
                    'lang_links' => __( 'Lang list only', 'element-bits' ),
                ],
            ]
        );

        $this->add_control(
            'handle',
            [
                'label' => __( 'Choose handle', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flag' => [
                        'title' => __( 'Flag', 'element-bits' ),
                        'icon' => 'fa fa-flag',
                    ],
                    'code' => [
                        'title' => __( 'Code', 'element-bits' ),
                        'icon' => 'fa fa-language',
                    ],
                    'flag_code' => [
                        'title' => __( 'Flag & Code', 'element-bits' ),
                        'icon' => 'fa fa-globe',
                    ],
                ],
                'default' => 'flag',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'handle_color',
            [
                'label' => __( 'Handle Color', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#222',
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eb-lang-switch-handle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'handle_align',
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
                'default' => 'left',
            ]
        );

        $this->add_control(
            'flag_style',
            [
                'label' => __( 'Flag Style', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'rounded',
                'options' => [
                    'rounded'  => __( 'Rounded', 'element-bits' ),
                    'circle' => __( 'Circle', 'element-bits' ),
                ],
            ]
        );

        $this->add_control(
            'lang_list_style',
            [
                'label' => __( 'Languages style', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid'  => __( 'Grid only flags', 'element-bits' ),
                    'list' => __( 'List flags and names', 'element-bits' ),
                    'list_names' => __( 'List only names(code)', 'element-bits' ),
                ],
            ]
        );

        $this->add_control(
            'handle_flag_width',
            [
                'label' => __( 'Handle flag width', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 100,
                'step' => 1,
                'default' => 32,
            ]
        );

        $this->add_control(
            'flags_width',
            [
                'label' => __( 'Language flags width', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 100,
                'step' => 1,
                'default' => 64,
            ]
        );

        $this->end_controls_section();
    }

    private function langs() {
        if ( function_exists('icl_object_id') ) {
            return apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );
        }

        return false;
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
        ?>
        <div class="eb-lang-switch" data-eb-eid="<?php echo esc_attr( $this->get_id() ); ?>">
            <?php if( $langs = $this->langs() ) : ?>

                <?php if( $settings['display_content'] !== 'lang_links' ) : ?>
                    <?php $this->display_lang_switch(); ?>

                    <div
                        class="eb-lang-switch-modal eb-modal-box"
                        data-eb-modal="<?php echo esc_attr( $this->get_id() ); ?>"
                        aria-hidden="true"
                        role="dialog"
                        aria-modal="true">
                        <h4 class="eb-lang-switch-modal-title"><?php _e( 'Languages', 'element-bits' ); ?></h4>

                        <?php $this->display_language_links(); ?>
                    </div>
                <?php else : ?>
                    <?php $this->display_language_links(); ?>
                <?php endif; ?>

            <?php else : ?>
                <p>WPML is not installed</p>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Render languages list
     *
     * @since 1.3
     */
    private function display_language_links() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'ul-list', [
            'class' => [
                'eb-wpml-lang-switch-list',
                'eb-wpml-lang-switch-list--' . $settings['lang_list_style'],
            ]
        ]);

        if( $settings['lang_list_style'] == 'list' || $settings['lang_list_style'] == 'list_names' ) :
        ?>
            <ul <?php echo $this->get_render_attribute_string( 'ul-list' ); ?>>
                <?php foreach ( $this->langs() as $l ) : ?>
                    <li>
                        <a
                            href="<?php echo esc_url( $l['url'] ); ?>"
                            class="eb-lang-switch-handle"
                            data-eb-eid="<?php echo esc_attr( $this->get_id() ); ?>">
                            <span>
                                <?php echo esc_attr( $l['translated_name'] ); ?>
                                (<?php echo strtoupper( esc_attr( $l['language_code'] ) ); ?>)
                            </span>

                            <?php if( $settings['lang_list_style'] == 'list' ) : ?>
                                <img
                                class="eb-lang-switch-flag <?php echo $settings['flag_style'] == 'circle' ? 'eb-lang-switch-flag-circle' : null; ?>"
                                style="width:<?php echo esc_attr( $settings['flags_width'] ); ?>px"
                                src="<?php echo esc_url( get_theme_file_uri( './assets/svg/flags/'.$settings['flag_style'].'/'.$l['language_code'].'.svg' )); ?>"
                                    alt="Country flag for <?php esc_attr( $l['native_name'] ); ?>"/>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if( $settings['lang_list_style'] == 'grid' ) : ?>
            <div class="eb-wpml-lang-switch-grid">
                <?php foreach ( $this->langs() as $l ) : ?>
                    <a
                        href="<?php echo esc_url( $l['url'] ); ?>"
                        class="eb-lang-switch-handle"
                        data-eb-eid="<?php echo esc_attr( $this->get_id() ); ?>">
                        <img
                            class="eb-lang-switch-flag <?php echo $settings['flag_style'] == 'circle' ? 'eb-lang-switch-flag-circle' : null; ?>"
                            style="width:<?php echo esc_attr( $settings['flags_width'] ); ?>px"
                            src="<?php echo esc_url( get_theme_file_uri( './assets/svg/flags/'.$settings['flag_style'].'/'.$l['language_code'].'.svg' )); ?>"
                            alt="Country flag for <?php esc_attr( $l['native_name'] ); ?>"/>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif;
    }

    /**
     * Render language switch
     *
     * @since 1.3
     */
    private function display_lang_switch() {
        $settings = $this->get_settings_for_display();

        if( $langs = $this->langs() ) :
        ?>
            <?php foreach ( $langs as $l ) : ?>
                <?php if( $l['active'] ) : ?>
                    <a
                        href="#"
                        class="eb-lang-switch-handle ntrjs-eb-lang-switch-handle"
                        data-eb-eid="<?php echo esc_attr( $this->get_id() ); ?>"
                        style="justify-content:<?php echo esc_attr( $settings['handle_align'] ); ?>">

                        <?php if( $settings['handle'] === 'code' || $settings['handle'] === 'flag_code' ) : ?>
                            <span><?php echo strtoupper( esc_attr( $l['language_code'] ) ); ?></span>
                            <?php echo $settings['handle'] === 'flag_code' ? '&nbsp;' : null ?>
                        <?php endif; ?>

                        <?php if( $settings['handle'] === 'flag' || $settings['handle'] === 'flag_code' ) : ?>
                            <img
                                class="eb-lang-switch-flag <?php echo $settings['flag_style'] == 'circle' ? 'eb-lang-switch-flag-circle' : null; ?>"
                                style="width:<?php echo esc_attr( $settings['handle_flag_width'] ); ?>px"
                                src="<?php echo esc_url( get_theme_file_uri( './assets/svg/flags/'.$settings['flag_style'].'/'.$l['language_code'].'.svg' )); ?>"
                                alt="Country flag for <?php esc_attr( $l['translated_name'] ); ?>"/>
                        <?php endif; ?>

                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif;
    }
}
