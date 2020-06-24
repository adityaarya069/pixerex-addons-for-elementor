<?php

namespace PixerexAddons\Admin\Includes;

use PixerexAddons\Helper_Functions;

if ( ! defined( 'ABSPATH' ) ) exit;

class Papro_Actions {

    public function create_pro_menus() {
        
        add_submenu_page(
            'Pixerex-addons',
            '',
            '<span class="dashicons dashicons-star-filled" style="font-size: 17px"></span> ' . __( 'Get PRO Widgets & Addons', 'pixerex-addons-for-elementor' ),
            'manage_options',
            'pixerex-addons-pro',
            [ $this, 'handle_custom_redirects' ]
        );
        
    }


    public function handle_custom_redirects() {

        $theme_slug = Helper_Functions::get_installed_theme();

        if ( empty( $_GET['page'] ) ) {
            return;
        }

        if ( 'pixerex-addons-pro' === $_GET['page'] ) {

            $url = sprintf('https://pixerexaddons.com/pro/?utm_source=wp-menu&utm_medium=wp-dash&utm_campaign=get-pro&utm_term=%s', $theme_slug );
            
            wp_redirect( $url );

            die();
        }
    }
    

	public function change_admin_menu_name() {
        
        global $submenu;
        
        if( isset($submenu['pixerex-addons'] ) ) {
            $submenu['pixerex-addons'][0][0] = __( 'Settings', 'pixerex-addons-for-elementor' );
        }
    }

    public function on_admin_init() {

        $this->handle_custom_redirects();

    }

	public function __construct() {

        add_action( 'admin_init', [ $this, 'on_admin_init' ] );

        if( ! defined('pixerex_PRO_ADDONS_VERSION') )
            add_action( 'admin_menu', array ( $this,'create_pro_menus' ), 100 );

		add_action( 'admin_menu', array ( $this, 'change_admin_menu_name'), 100 );

	}    
}