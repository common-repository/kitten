<?php

class Kitten {
    public function __construct() {
        $this->requiring_files();

        new \Kitten\Admin;
        new \Kitten\Elementor;
        new \Kitten\Elementor\Kit;
    }

    private function requiring_files() {
        require_once KITTEN_PATH . 'core/class-admin-area.php';
        
        /** ELementor Stuff */
        require_once KITTEN_PATH . 'elementor/kits/class-kit.php';
        /** ELementor Widgets */
        require_once KITTEN_PATH . 'elementor/class-elementor.php';
    }
}