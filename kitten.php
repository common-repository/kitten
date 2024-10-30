<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://desgrammer.com
 * @since             0.0.1
 * @package           Kitten
 *
 * @wordpress-plugin
 * Plugin Name:       Kitten - Elementor Kit & Widgets
 * Plugin URI:        https://desgrammer.com/kitten
 * Description:       Plugin addon Elementor yang memudahkan dalam pembuatan sebuah website.
 * Version:           1.0.4
 * Author:            DesGrammer
 * Author URI:        https://desgrammer.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kitten
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'KITTEN_VERSION', '1.0.4' );
/**
 * Define Kitten path and uri
 */
define( 'KITTEN_PLUGIN_FILE', __FILE__ );
define( 'KITTEN_PATH', plugin_dir_path( __FILE__ ) );
define( 'KITTEN_URL', plugin_dir_url( __FILE__ ) );

define( 'KITTEN_BASENAME', plugin_basename( __FILE__ ) );
define( 'KITTEN_BASEDIR', plugin_basename( __DIR__ ) );

define( 'KITTEN_TESTED_ELEMENTOR_VERSION', '3.4.4' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kitten-activator.php
 */
function activate_kitten() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kitten-activator.php';
	Kitten_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kitten-deactivator.php
 */
function deactivate_kitten() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kitten-deactivator.php';
	Kitten_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kitten' );
register_deactivation_hook( __FILE__, 'deactivate_kitten' );

function kitten_admin_notice_missing_main_plugin() {
    if ( isset( $_GET['activate'] ) ) {
        unset( $_GET['activate'] );
    }

    $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'kitten' ),
        '<strong>' . esc_html__( 'Elementor Hello World', 'kitten' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'kitten' ) . '</strong>'
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
}

function kitten_admin_notice_minimum_elementor_version() {
    if ( isset( $_GET['activate'] ) ) {
        unset( $_GET['activate'] );
    }

    $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
        esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'kitten' ),
        '<strong>' . esc_html__( 'Elementor Hello World', 'kitten' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'kitten' ) . '</strong>',
        KITTEN_TESTED_ELEMENTOR_VERSION
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'core/class-kitten.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kitten() {
	// Check if Elementor installed and activated
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'kitten_admin_notice_missing_main_plugin' );
		return;
	}

	// Check for required Elementor version
	if ( ! version_compare( ELEMENTOR_VERSION, KITTEN_TESTED_ELEMENTOR_VERSION, '>=' ) ) {
		add_action( 'admin_notices', 'kitten_admin_notice_minimum_elementor_version' );
		return;
	}

	$plugin = new Kitten();
}
run_kitten();
