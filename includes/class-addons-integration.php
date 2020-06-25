<?php

namespace PixerexAddons;

use PixerexAddons\Admin\Settings\Maps;
use PixerexAddons\Admin\Settings\Modules_Settings;
use PixerexAddons\Helper_Functions;

if( ! defined( 'ABSPATH' ) ) exit();

class Addons_Integration {
    
    //Class instance
    private static $instance = null;
    
    //Modules Keys
    private static $modules = null;
    
    //`Pixerex_Template_Tags` Instance
    protected $templateInstance;


    //Maps Keys
    private static $maps = null;
    
    
    /**
    * Initialize integration hooks
    *
    * @return void
    */
    public function __construct() {
        
        self::$modules = Modules_Settings::get_enabled_keys();
        
        self::$maps = Maps::get_enabled_keys();
        
        $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
        
        add_action( 'elementor/editor/before_enqueue_styles', array( $this, 'pixerex_font_setup' ) );
        
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_area' ) );
        
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this,'enqueue_editor_scripts') );
        
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_preview_styles' ) );
        
        add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_frontend_styles' ) );
        
        add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_frontend_scripts' ) );
        
        add_action( 'wp_ajax_get_elementor_template_content', array( $this, 'get_template_content' ) );
        
    }
    
    /**
    * Loads plugin icons font
    * @since 1.0.0
    * @access public
    * @return void
    */
    public function pixerex_font_setup() {
        
        wp_enqueue_style(
            'pixerex-addons-font',
            PIXEREX_ADDONS_URL . 'assets/editor/css/style.css',
            array(),
            PIXEREX_ADDONS_VERSION
        );
        
        $badge_text = Helper_Functions::get_badge();
        
        $dynamic_css = sprintf( '[class^="pa-"]::after, [class*=" pa-"]::after { content: "%s"; }', $badge_text ) ;

        wp_add_inline_style( 'pixerex-addons-font',  $dynamic_css );
        
    }
    
    /** 
    * Register Frontend CSS files
    * @since 2.9.0
    * @access public
    */
    public function register_frontend_styles() {
        
        $dir = Helper_Functions::get_styles_dir();
		$suffix = Helper_Functions::get_assets_suffix();
        
        $is_rtl = is_rtl() ? '-rtl' : '';
        
        wp_register_style(
            'pa-prettyphoto',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/prettyphoto' . $is_rtl . $suffix . '.css',
            array(),
            PIXEREX_ADDONS_VERSION,
            'all'
        );
        
        wp_register_style(
            'pixerex-addons',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/pixerex-addons' . $is_rtl . $suffix . '.css',
            array(),
            PIXEREX_ADDONS_VERSION,
            'all'
        );
        
    }
    
    /**
     * Enqueue Preview CSS files
     * 
     * @since 2.9.0
     * @access public
     * 
     */
    public function enqueue_preview_styles() {
        
        wp_enqueue_style( 'pa-prettyphoto' );
        
        wp_enqueue_style( 'pixerex-addons' );

    }
    
    /** 
     * Load widgets require function
     * 
     * @since 1.0.0
     * @access public
     * 
     */
    public function widgets_area() {
        $this->widgets_register();
    }
    
    /**
     * Requires widgets files
     * 
     * @since 1.0.0
     * @access private
     */
    private function widgets_register() {

        $check_component_active = self::$modules;
        
        foreach ( glob( PIXEREX_ADDONS_PATH . 'widgets/' . '*.php' ) as $file ) {
            
            $slug = basename( $file, '.php' );
            
            $enabled = isset( $check_component_active[ $slug ] ) ? $check_component_active[ $slug ] : '';
            
            if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $check_component_active ) {
                $this->register_addon( $file );
            }
        }

    }
    
    /**
     * Registers required JS files
     * 
     * @since 1.0.0
     * @access public
    */
    public function register_frontend_scripts() {
        
        $maps_settings = self::$maps;
        
        $dir = Helper_Functions::get_scripts_dir();
		$suffix = Helper_Functions::get_assets_suffix();
        
        $locale = isset ( $maps_settings['pixerex-map-locale'] ) ? $maps_settings['pixerex-map-locale'] : "en";
        
        wp_register_script(
            'pixerex-addons-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/pixerex-addons' . $suffix . '.js',
            array('jquery'),
            PIXEREX_ADDONS_VERSION,
            true
        );
        
        wp_register_script(
            'prettyPhoto-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/prettyPhoto' . $suffix . '.js',
            array('jquery'),
            PIXEREX_ADDONS_VERSION,
            true
        );
        
        wp_register_script(
            'vticker-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/vticker' . $suffix . '.js',
            array('jquery'),
            PIXEREX_ADDONS_VERSION,
            true
        );
        wp_register_script(
            'typed-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/typed' . $suffix . '.js',
            array('jquery'),
            PIXEREX_ADDONS_VERSION,
            true
        );
        
        wp_register_script(
            'count-down-timer-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/jquery-countdown' . $suffix . '.js',
            array('jquery'),
            PIXEREX_ADDONS_VERSION,
            true
        );
       
        wp_register_script(
            'isotope-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/isotope' . $suffix . '.js',
            array('jquery'),
            PIXEREX_ADDONS_VERSION,
            true
        );

        wp_register_script(
            'modal-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/modal' . $suffix . '.js',
            array('jquery'),
            PIXEREX_ADDONS_VERSION,
            true
        );
        
        wp_register_script(
            'pixerex-maps-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/pixerex-maps' . $suffix . '.js',
            array( 'jquery', 'pixerex-maps-api-js' ),
            PIXEREX_ADDONS_VERSION,
            true
        );

        wp_register_script( 
            'vscroll-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/pixerex-vscroll' . $suffix . '.js',
            array('jquery'),
            PIXEREX_ADDONS_VERSION,
            true
        );
        
       wp_register_script( 
           'slimscroll-js',
           PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/jquery-slimscroll' . $suffix . '.js',
           array('jquery'),
           PIXEREX_ADDONS_VERSION,
           true
       );
       
       wp_register_script( 
           'iscroll-js',
           PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/iscroll' . $suffix . '.js',
           array('jquery'),
           PIXEREX_ADDONS_VERSION,
           true
       );
       
       wp_register_script(
            'tilt-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/universal-tilt' . $suffix . '.js',
            array( 'jquery' ), 
            PIXEREX_ADDONS_VERSION, 
            true
        );

        wp_register_script(
            'lottie-js',
            PIXEREX_ADDONS_URL . 'assets/frontend/' . $dir . '/lottie' . $suffix . '.js',
            array( 'jquery' ), 
            PIXEREX_ADDONS_VERSION, 
            true
        );
       
       if( $maps_settings['pixerex-map-cluster'] ) {
            wp_register_script(
                'google-maps-cluster',
                'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js',
                array(),
                PIXEREX_ADDONS_VERSION,
                false
            );
        }
        
        if( $maps_settings['pixerex-map-disable-api'] && '1' != $maps_settings['pixerex-map-api'] ) {
			$api = sprintf ( 'https://maps.googleapis.com/maps/api/js?key=%1$s&language=%2$s', $maps_settings['pixerex-map-api'], $locale );
            wp_register_script(
                'pixerex-maps-api-js',
                $api,
                array(),
                PIXEREX_ADDONS_VERSION,
                false
            );
        }
        
        $data = array(
            'ajaxurl'       => esc_url( admin_url( 'admin-ajax.php' ) )
        );
        
		wp_localize_script( 'pixerex-addons-js', 'PixerexSettings', $data );
        
    }
    
    /*
     * Enqueue editor scripts
     * 
     * @since 3.2.5
     * @access public
     */
    public function enqueue_editor_scripts() {
		
		$map_enabled = isset( self::$modules['pixerex-maps'] ) ? self::$modules['pixerex-maps'] : 1;
        
		if( $map_enabled ) {
		
        	$pixerex_maps_api = self::$maps['pixerex-map-api'];
        
        	$locale = isset ( self::$maps['pixerex-map-locale'] ) ? self::$maps['pixerex-map-locale'] : "en";

        	$pixerex_maps_disable_api = self::$maps['pixerex-map-disable-api'];
        
        	if ( $pixerex_maps_disable_api && '1' != $pixerex_maps_api ) {
                
				$api = sprintf ( 'https://maps.googleapis.com/maps/api/js?key=%1$s&language=%2$s', $pixerex_maps_api, $locale );
            	wp_enqueue_script(
                	'pixerex-maps-api-js',
                	$api,
                	array(),
                	PIXEREX_ADDONS_VERSION,
                	false
            	);

        	}

			wp_enqueue_script(
				'pa-maps-finder',
				PIXEREX_ADDONS_URL . 'assets/editor/js/pa-maps-finder.js',
				array( 'jquery' ),
				PIXEREX_ADDONS_VERSION,
				true
			);

        }

    }
    
    /*
     * Get Template Content
     * 
     * Get Elementor template HTML content.
     * 
     * @since 3.2.6
     * @access public
     * 
     */
    public function get_template_content() {
        
        $template = $_GET['templateID'];
        
        if( ! isset( $template ) ) {
            return;
        }
        
        $template_content = $this->templateInstance->get_template_content( $template );
        
        if ( empty ( $template_content ) || ! isset( $template_content ) ) {
            wp_send_json_error();
        }
        
        $data = array(
            'template_content'  => $template_content
        );
        
        wp_send_json_success( $data );
        
    }
    
    /**
     * 
     * Register addon by file name.
     * 
     * @access public
     *
     * @param  string $file            File name.
     * @param  object $widgets_manager Widgets manager instance.
     * 
     * @return void
     */
    public function register_addon( $file ) {
        
        $widget_manager = \Elementor\Plugin::instance()->widgets_manager;
        
        $base  = basename( str_replace( '.php', '', $file ) );
        $class = ucwords( str_replace( '-', ' ', $base ) );
        $class = str_replace( ' ', '_', $class );
        $class = sprintf( 'PixerexAddons\Widgets\%s', $class );
        
        if( 'PixerexAddons\Widgets\Pixerex_Contactform' != $class ) {
            require $file;
        } else {
            if( function_exists('wpcf7') ) {
                require $file;
            }
        }
        
        if ( 'PixerexAddons\Widgets\Pixerex_Blog' == $class ) {
            require_once ( PIXEREX_ADDONS_PATH . 'widgets/dep/queries.php' );
        }

        if ( class_exists( $class ) ) {
            $widget_manager->register_widget_type( new $class );
        }
		$this->pixerex_deregister_widgets();
    }
    
	
	 public function pixerex_deregister_widgets(  ) {
		 global $elementor_widget_blacklist;
			$elementor_widget_blacklist = [
				
				//array of Widgets names to be Removed
			];
			add_action('elementor/widgets/widgets_registered', function($widgets_manager){
			  global $elementor_widget_blacklist;

			  foreach($elementor_widget_blacklist as $widget_name){
				$widgets_manager->unregister_widget_type($widget_name);
			  }
			}, 15);
	 }
    /**
     * 
     * Creates and returns an instance of the class
     * 
     * @since 1.0.0
     * @access public
     * 
     * @return object
     * 
     */
   public static function get_instance() {
       if( self::$instance == null ) {
           self::$instance = new self;
       }
       return self::$instance;
   }
}
    

if ( ! function_exists( 'pixerex_addons_integration' ) ) {

	/**
	 * Returns an instance of the plugin class.
	 * @since  1.0.0
	 * @return object
	 */
	function pixerex_addons_integration() {
		return Addons_Integration::get_instance();
	}
}
pixerex_addons_integration();