<?php

namespace Kitten;

class Admin {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_to_wp_admin' ) );
        add_action( 'in_admin_header', array( $this, 'remove_all_notices' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts_and_styles' ) );
        add_action( 'wp_ajax_handle_logout_dg_account', array( $this, 'handle_logout_dg_account' ) );
    }

    /**
     * Register Kitten Menu
     *
     * @since 1.0.1
     * @return void
     */
    public function add_menu_to_wp_admin() {
        add_menu_page(
            __( 'Kitten', 'kitten' ),
            'Kitten',
            'manage_options',
            'kitten',
            function () {
                include_once KITTEN_PATH . 'templates/admin/main.php';
            },
            KITTEN_URL . 'assets/images/kitten-icon.png',
            55
        );
    }

    /**
     * Remove admin notices on kitten page
     *
     * @since 1.0.1
     * @return void
     */
    public function remove_all_notices() {
		global $current_screen;
		if ( strpos( $current_screen->id, 'kitten' ) !== false ) {
			remove_all_actions( 'user_admin_notices' );
			remove_all_actions( 'admin_notices' );
		}
    }

    /**
     * Register script and styles on admin side
     *
     * @since 1.0.3
     * @return void
     */
    public function register_scripts_and_styles() {
        global $current_screen;

        wp_register_style( 'kitten-global', KITTEN_URL . 'assets/admin/css/global.css', array(), KITTEN_VERSION );
        wp_register_style( 'kitten-admin', KITTEN_URL . 'assets/admin/css/main.css', array(), KITTEN_VERSION );
        wp_register_script( 'kitten-admin', KITTEN_URL . 'assets/admin/js/main.js', array( 'jquery' ), KITTEN_VERSION );

        wp_enqueue_style( 'kitten-global' );
        if ( strpos( $current_screen->id, 'kitten' ) !== false ) {
            wp_enqueue_style( 'kitten-admin' );
            wp_enqueue_script( 'kitten-admin' );
            wp_localize_script( 'kitten-admin', 'kitten', array(
                'credentials' => get_option( 'dg_authentication_credentials' ),
                'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
            ) );
        }
    }

    /**
     * Handle logout to DG Account
     *
     * @since 1.0.1
     * @return void
     */
    public function handle_logout_dg_account() {
        update_option( 'dg_authentication_credentials', false );

        wp_send_json( array(
            'success' => true,
        ) );
    }
}