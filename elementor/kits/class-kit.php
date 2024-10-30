<?php

namespace Kitten\Elementor;

class Kit {
    public function __construct() {
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'register_editor_assets' ) );
        add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'register_editor_assets' ) );
        add_action( 'wp_ajax_dg_handle_login_credentials', array( $this, 'handle_login_credentials' ) );

        add_action( 'admin_post_dg_handle_receiving_app_password', array( $this, 'handle_receiving_app_password' ) );
        add_action( 'admin_post_nopriv_dg_handle_receiving_app_password', array( $this, 'handle_receiving_app_password' ) );
    }

    /**
     * Handle ajax login Credentials
     *
     * @since 1.0.3
     * @return void
     */
    public function handle_login_credentials() {
        $body = array_map( 'sanitize_text_field', (array) $_REQUEST['form'] );

        $response = wp_remote_post( 'https://desgrammer.com/wp-json/jwt-auth/v1/token', array(
            'body' => array(
                'username' => isset( $body['email'] ) ? sanitize_email( $body['email'] ) : '',
                'password' => isset( $body['password'] ) ? sanitize_text_field( $body['password'] ) : '',
            )
        ) );

        if ( is_wp_error( $response ) ) {
            $return = array(
                'success' => false,
                'message' => $response->get_error_message()
            );
        } else {
            $data = json_decode( $response['body'], true );
            if ( isset( $data['data'] ) && null !== $data['data']['status'] && $data['data']['status'] !== 200 ) {
                $error = new \WP_Error;
                $error->add_data( $data['message'], $data['code'] );

                $return = array(
                    'success' => false,
                    'message' => $data['message']
                );
            } else {
                update_option( 'dg_authentication_credentials', $data );
                
                $return = array(
                    'success' => true,
                    'data'    => $data
                );
            }

        }

        wp_send_json( $return );
        wp_die();
    }

    /**
     * Handle receiving app password from Server
     *
     * @since 1.0.3
     * @return void
     */
    public function handle_receiving_app_password() {
        unset( $_GET['action'] );
        update_option( 'dg_authentication_credentials', array_map( 'sanitize_text_field', (array) $_GET ) );

        wp_safe_redirect( admin_url( 'admin.php?page=kitten' ) );
    }

    /**
     * Register editor elementor asssets
     *
     * @since 1.0.1
     * @return void
     */
    public function register_editor_assets() {
        wp_register_style( 'kitten-elementor-kit', KITTEN_URL . 'assets/elementor/css/kit.css', array(), KITTEN_VERSION );
        wp_register_style( 'kitten-elementor-editor', KITTEN_URL . 'assets/elementor/editor/css/kitten-editor.min.css', array(), KITTEN_VERSION );
        wp_register_script( 'kitten-elementor-kit', KITTEN_URL . 'assets/elementor/js/kit.js', [ 'elementor-editor' ], KITTEN_VERSION, true );
        wp_register_script( 'kitten-elementor-editor', KITTEN_URL . 'assets/elementor/editor/js/kitten-editor.min.js', [ 'elementor-editor' ], KITTEN_VERSION, true );
        wp_localize_script( 'kitten-elementor-editor', 'kitten', array(
            'credentials' => get_option( 'dg_authentication_credentials' ),
            'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
        ) );
        wp_enqueue_style( 'kitten-elementor-kit' );
        wp_enqueue_script( 'kitten-elementor-kit' );
        wp_enqueue_style( 'kitten-elementor-editor' );
        wp_enqueue_script( 'kitten-elementor-editor' );
    }
}