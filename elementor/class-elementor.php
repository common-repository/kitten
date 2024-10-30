<?php

namespace Kitten;

use Elementor\Plugin;
use Kitten\Elementor\Widgets\Navigation_Menu;

class Elementor {
    public function __construct() {
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
        add_action( 'elementor/frontend/before_register_scripts', array( $this, 'register_editor_scripts' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_widget_categories' ) );
    }

    /**
     * Register Editor Scripts of widgets
     *
     * @return void
     */
    public function register_editor_scripts() {
        wp_register_style( 'kitten-widgets', KITTEN_URL . 'assets/elementor/widgets/css/frontend.css', array(), KITTEN_VERSION );
		wp_register_script( 'smartmenus', KITTEN_URL . 'assets/elementor/libs/smartmenus/jquery.smartmenus.js', [ 'jquery' ], '1.0.1', true );
    }

    /**
     * Register categories to Elementor Editor
     *
     * @param Element_Manager $elements_manager
     * @return void
     */
    public function register_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'kitten',
            [
                'title' => __( 'Kitten', 'kitten' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }
    
    /**
     * Function for registering widget to Elementor
     *
     * @return void
     */
    public function register_widgets() {
        require_once KITTEN_PATH . 'elementor/widgets/navigation-menu.php';
        
        Plugin::$instance->widgets_manager->register_widget_type( new Navigation_Menu() );
    }
}