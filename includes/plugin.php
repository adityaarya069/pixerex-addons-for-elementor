<?php

namespace PixerexAddons;

use PixerexAddons\Admin\Includes;
use PixerexAddons\Admin\Settings;

if ( ! defined( 'ABSPATH' ) ) exit;

class Plugin {

	public static $instance = null;

	public static function instance() {
        
		if ( is_null( self::$instance ) ) {
            
			self::$instance = new self();
            
		}

		return self::$instance;
	}
    
    public function init() {
        
		$this->init_components();
        
	}
    
    private function init_components() {
        
        new Settings\Maps();
    	new Settings\Modules_Settings();
	}
    
    private function __construct() {
		add_action( 'init', array( $this, 'init' ), 0 );
	}
}

if ( ! defined( 'ELEMENTOR_TESTS' ) ) {
	Plugin::instance();
}