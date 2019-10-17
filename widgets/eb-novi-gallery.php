<?php
namespace ElementBits\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;

defined( 'ABSPATH' ) || exit;

/**
 * Element bits widget Template.
 *
 * @package ElementBits
 * @author Kostas Charalampidis <skapator@gmail.com>
 * @since 1.0
 * @version 1.1
 */
class EB_Novi_Gallery extends EB_Widget_Base {

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
        return 'eb-novi-gallery';
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
        return __( 'EB: Novi Gallery', 'element-bits' );
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
        return [ 'novel', 'bits', 'novi-gallery' ];
    }

    public function get_script_depends() {
        return [ 'jquery-slick', 'eb-widget-novi-gallery' ];
    }

    public function get_style_depends() {
        return [ 'eb-widget-novi-gallery' ];
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
                'label' => __( 'Galleries', 'element-bits' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label' => __( 'Title', 'element-bits' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'List Title' , 'element-bits' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'wp_gallery',
            [
                'label' => __( 'Add Images', 'element-bits' ),
                'type'  => Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        $this->add_control(
            'galleries',
            [
                'label' => __( 'Galleries', 'element-bits' ),
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => __( 'Title', 'element-bits' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Title' , 'element-bits' ),
                    ],
                    [
                        'name' => 'wp_gallery',
                        'label' => __( 'Image (max. 12)', 'element-bits' ),
                        'type' => Controls_Manager::GALLERY,
                        'default' => [],
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'width',
            [
                'label' => __( 'Gallery width', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 100,
                'selectors' => [
                    '{{WRAPPER}} .eb-novi-gallery-wrapper' => 'width: {{VALUE}}%',
                ],
            ]
        );

        $this->add_control(
            'image_h',
            [
                'label' => __( 'Image height', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'step' => 1,
                'default' => 180,
            ]
        );

        $this->add_control(
            'image_gap',
            [
                'label' => __( 'Images gap', 'element-bits' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'step' => 1,
                'default' => 5,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Build image json data from wp image
     *
     * @return array $data
     */
    protected function items_json() {
        $settings = $this->get_settings_for_display();
        $data = [];
        if( $galleries = $settings['galleries'] ) {
            foreach( $galleries as $gallery ) {
                foreach( $gallery['wp_gallery'] as $i => $attachment ) {
                    $attachment_src = wp_get_attachment_image_src( $attachment['id'], 'large' );
                    $data[] = [
                        'title' => $gallery['title'] . ' #' . $i,
                        'src' => $attachment_src[0],
                        'w' => $attachment_src[1],
                        'h' => $attachment_src[2],
                        'pid' => $attachment['id'],
                        'idx' => $i,
                    ];
                }
            }
        }

        return $data;
    }

    /**
     * Build widget data for data attribute
     *
     * @return array
     */
    protected function widget_data_attr() {
        $settings = $this->get_settings_for_display();
        $data = [];
        $data['row_h'] = absint( $settings['image_h'] );
        $data['img_items'] = $this->items_json();
        $data['ebid'] = $this->get_id();
        $data['img_gap'] = absint( $settings['image_gap'] );

        return json_encode( $data );
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

        if( $galleries = $settings['galleries'] ) :

            $this->add_render_attribute(
                'wrapper',
                [
                    'class' => [ 'eb-novi-gallery-wrapper' ],
                    'data-eb-data' => $this->widget_data_attr()
                ]
            );
        ?>
            <div class="eb-novi-gallery-wrapper eb-widget-warpper" <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                <div class="eb-novi-gallery-mobile-nav"></div>
                <div class="eb-novi-gallery-tabs">
                    <?php foreach( $galleries as $i => $gallery ) : ?>
                        <button
                            type="button"
                            data-idx="<?php echo (int)$i; ?>"
                            <?php echo $i === 0 ? 'class="eb-active"' : null;?>>
                            <?php echo $gallery['title']; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <?php $items = $this->items_json(); ?>
                <div class="eb-loading-wrapper">
                    <div class="eb-loading"></div>
                </div>
                <div
                    class="eb-novi-gallery-slides eb-novi-gallery-slides-<?php echo esc_attr( $this->get_id() ); ?>">
                    <?php $idx = 0; ?>
                    <?php foreach( $galleries as $gallery ) : ?>
                        <div class="eb-novi-gallery-slick">
                            <div class="eb-novi-gallery-container" itemscope itemtype="http://schema.org/ImageGallery">
                                <?php foreach( $gallery['wp_gallery'] as $attachment ) : ?>
                                    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                        <a
                                            href="<?php echo $items[$idx]['src']; ?>"
                                            data-eb-idx="<?php echo $idx++;?>"
                                            data-elementor-open-lightbox="no">
                                            <?php echo wp_get_attachment_image( $attachment['id'], 'medium', [ 'itemProp' => 'thumbnail' ] ); ?>
                                        </a>
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php
        endif;
    }

}
