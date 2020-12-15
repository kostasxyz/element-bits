<?php
namespace ElementBits;

defined( 'ABSPATH' ) || exit;

class Settings extends \Elementor\Settings {

    public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ], 111 );
		add_action( 'admin_init', [ $this, 'settings_init_general' ] );
    }

    public function add_admin_menu() {
		add_submenu_page(
            \Elementor\Settings::PAGE_ID,
            'Element Bits',
            __( 'ElementBits', 'elements-bits' ),
            'manage_options',
            'element_bits',
            [ $this, 'settings_page_render' ]
        );
    }

    /**
     * Settings page render
     */
    public function settings_page_render() {
        ?>
            <h1>Element Bits Settings</h1>
            <hr />
            <?php settings_errors(); ?>
            <form method="post" action="options.php" class="elementbits-settings-form">
                <?php settings_fields( 'elementbits_settings_group' ); ?>
                <?php do_settings_sections( 'elementbits_settings' ); ?>
                <?php submit_button(); ?>
            </form>
        <?php
    }

    /**
     * Settins api init
     */
    public function settings_init_general() {
        register_setting(
            'elementbits_settings_group',
            'elementbits_settings',
            [
                'sanitize_callback' => [ $this, 'sanitize' ],
				'default'           => null,
            ]
        );

        add_settings_section( 'elementbits_settings_section', 'General Settings', null, 'elementbits_settings' );

        add_settings_field( 'gmaps-key', 'Google API Key', [ $this, 'settings_field_gmaps_api' ], 'elementbits_settings', 'elementbits_settings_section' );
    }

    public function settings_field_gmaps_api() {
        $gmap_key = esc_attr( $this->options( 'gmap_key' ) );
        ?>
            <input type="text" name="elementbits_settings[gmap_key]" value="<?php echo $gmap_key; ?>" class="regular-text" />
        <?php
    }

    public function sanitize($input) {
        return $input;
    }

    public function options( $key = null ) {
        $options = get_option( 'elementbits_settings' );

        if( $key ) {
            if( isset( $options[$key] ) )
                return $options[$key];
            else
                return null;
        }

        return $options;
    }
}
