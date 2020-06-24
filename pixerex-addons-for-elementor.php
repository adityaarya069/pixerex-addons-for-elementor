<?php
/*
Plugin Name: Pixerex Addons for Elementor
Description: Pixerex Addons Plugin Includes 22+ Pixerex widgets for Elementor Page Builder.
Plugin URI: https://Pixerexaddons.com
Version: 3.20.6
Author: Pixerex
Author URI: https://leap13.com/
Text Domain: Pixerex-elementor-elements
Domain Path: /languages
License: GNU General Public License v3.0
*/

if ( ! defined('ABSPATH') ) exit; // No access of directly access

// Define Constants
define('PIXEREX_ADDONS_VERSION', '3.20.6');
define('PIXEREX_ADDONS_URL', plugins_url( '/', __FILE__ ) );
define('PIXEREX_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
define('PIXEREX_ADDONS_FILE', __FILE__);
define('PIXEREX_ADDONS_BASENAME', plugin_basename( PIXEREX_ADDONS_FILE ) );
define('PIXEREX_ADDONS_STABLE_VERSION', '3.20.5');

if( ! class_exists('Pixerex_Addons_Elementor') ) {
    
    /*
    * Intialize and Sets up the plugin
    */
    class Pixerex_Addons_Elementor {
        
        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance = null;
        
        /**
         * Sets up needed actions/filters for the plug-in to initialize.
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function __construct() {
            
            add_action( 'plugins_loaded', array( $this, 'Pixerex_addons_elementor_setup' ) );
            
            add_action( 'elementor/init', array( $this, 'elementor_init' ) );
            
            add_action( 'init', array( $this, 'init' ), -999 );
 
            add_action( 'admin_post_pixerex_addons_rollback', 'post_pixerex_addons_rollback' );
            
            register_activation_hook( PIXEREX_ADDONS_FILE, array( $this, 'set_transient' ) );
            
        }
        
        /**
         * Installs translation text domain and checks if Elementor is installed
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function pixerex_addons_elementor_setup() {
            
            $this->load_domain();
            
            $this->init_files(); 
        }
        
        /**
         * Set transient for admin review notice
         * 
         * @since 3.1.7
         * @access public
         * 
         * @return void
         */
        public function set_transient() {
            
            $cache_key = 'pixerex_notice_' . PIXEREX_ADDONS_VERSION;
            
            $expiration = 3600 * 72;
            
            set_transient( $cache_key, true, $expiration );
        }
        
        
        /**
         * Require initial necessary files
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return void
         */
        public function init_files() {
            
            require_once ( PIXEREX_ADDONS_PATH . 'includes/class-helper-functions.php' );
            require_once ( PIXEREX_ADDONS_PATH . 'admin/settings/maps.php' );
            require_once ( PIXEREX_ADDONS_PATH . 'admin/settings/modules-setting.php' );
            require_once ( PIXEREX_ADDONS_PATH . 'includes/elementor-helper.php' );
            
            if ( is_admin() ) {
                
                require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/dep/maintenance.php');
                require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/dep/rollback.php');
                
                require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/dep/admin-helper.php');
                require_once ( PIXEREX_ADDONS_PATH . 'includes/class-beta-testers.php');
                require_once ( PIXEREX_ADDONS_PATH . 'includes/plugin.php');
                require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/admin-notices.php' );
                require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/plugin-info.php');
                require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/version-control.php');
                require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/reports.php');
                require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/papro-actions.php');
                $beta_testers = new Pixerex_Beta_Testers();
                
            }
    
        }
        
        /**
         * Load plugin translated strings using text domain
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return void
         */
        public function load_domain() {
            
            load_plugin_textdomain( 'pixerex-elementor-elements' );
            
        }
        
        /**
         * Elementor Init
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return void
         */
        public function elementor_init() {
            
            require_once ( PIXEREX_ADDONS_PATH . 'includes/compatibility/class-pixerex-addons-wpml.php' );
            
            require_once ( PIXEREX_ADDONS_PATH . 'includes/class-addons-category.php' );
            
        }
        
        /**
         * Load required file for addons integration
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return void
         */
        public function init_addons() {
            require_once ( PIXEREX_ADDONS_PATH . 'includes/class-addons-integration.php' );
        }
        
        /**
         * Load the required files for templates integration
         * 
         * @since 3.6.0
         * @access public
         * 
         * @return void
         */
        public function init_templates() {
            //Load templates file
            require_once ( PIXEREX_ADDONS_PATH . 'includes/templates/templates.php');
        }
        
        /*
         * Init 
         * 
         * @since 3.4.0
         * @access public
         * 
         * @return void
         */
        public function init() {
            
            $this->init_addons();
            
            if ( PixerexAddons\Admin\Settings\Modules_Settings::check_pixerex_templates() )
                $this->init_templates();
            
        }


        /**
         * Creates and returns an instance of the class
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return object
         */
        public static function get_instance() {
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
    
    }
}

if ( ! function_exists( 'pixerex_addons' ) ) {
    
	/**
	 * Returns an instance of the plugin class.
	 * @since  1.0.0
	 * @return object
	 */
	function pixerex_addons() {
		return Pixerex_Addons_Elementor::get_instance();
	}
}

Pixerex_addons();