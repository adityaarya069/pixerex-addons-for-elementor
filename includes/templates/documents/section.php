<?php

namespace PixerexAddons\Includes\Templates\Documents;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pixerex_Section_Document extends Pixerex_Document_Base {
    
     public function get_name() {
		return 'pixerex_page';
	}

	public static function get_title() {
		return __( 'Section', 'pixerex-addons-for-elementor' );
	}

	public function has_conditions() {
		return false;
	}

}