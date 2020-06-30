<?php

namespace PixerexAddons;

if( ! defined('ABSPATH') ) exit;

class Helper_Functions {
    
    private static $google_localize = null;
    
    /**
	 * script debug enabled
	 *
	 * @var script_debug
	 */
	private static $script_debug = null;
    
    /**
	 * JS scripts directory
	 *
	 * @var js_dir
	 */
	private static $js_dir = null;
    
    /**
	 * CSS fiels directory
	 *
	 * @var js_dir
	 */
	private static $css_dir = null;

	/**
	 * JS Suffix
	 *
	 * @var js_suffix
	 */
	private static $assets_suffix = null;
    
    /**
     * Check if white labeling - hide rating message is checked
     * 
     * @since 1.0.0
     * @return boolean
     * 
     */
   
   
    /**
     * Check if white labeling - hide version control page is checked
     * 
     * @since 1.0.0
     * @return boolean
     * 
     */

  
    
    /**
     * Check if white labeling - Free version name field is set
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function name() {
        
        if( defined('PIXEREX_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-plugin-name'])){
                $name_free = get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-plugin-name'];
            }
        }
        
        return ( isset( $name_free ) && '' != $name_free ) ? $name_free : 'Pixerex Addons for Elementor';
    }
    
    /**
     * Check if white labeling - Hide row meta option is checked
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function is_hide_row_meta() {
        
        if( defined('PIXEREX_PRO_ADDONS_VERSION') ) {
            if( isset( get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-row'] ) ){
                $hide_meta = get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-row'];
            }
        }
        
        return isset( $hide_meta ) ? $hide_meta : false;
    }
   
    /**
     * Check if white labeling - Hide plugin logo option is checked
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function is_hide_logo() {
        
        if( defined('PIXEREX_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-logo'])){
                $hide_logo = get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-logo'];
            }
        }
        
        return isset( $hide_logo ) ? $hide_logo : false;
    }
    
    /**
     * Get White Labeling - Widgets Category string
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_category() {
        
        if( defined('PIXEREX_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-short-name'])){
                $category = get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-short-name'];
            }
        }
        
        return ( isset( $category ) && '' != $category ) ? $category : __( 'Pixerex Addons', 'pixerex-elementor-elements' );
        
    }
    
    /**
     * Get White Labeling - Widgets Prefix string
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_prefix() {
        
        if( defined('PIXEREX_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-prefix'])){
                $prefix = get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-prefix'];
            }
        }
        
        return ( isset( $prefix ) && '' != $prefix ) ? $prefix : __('Pixerex', 'pixerex-elementor-elements');
    }
    
    /**
     * Get White Labeling - Widgets Badge string
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_badge() {
        
        if( defined('PIXEREX_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-badge'])){
                $badge = get_option('pr_wht_lbl_save_settings')['pixerex-wht-lbl-badge'];
            }
        }
        
        return ( isset( $badge ) && '' != $badge ) ? $badge : 'PA';
    }
    
    /**
     * Get Google Maps localization prefixes
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_google_languages() {
        
        if ( null === self::$google_localize ) {

			self::$google_localize = array(
				 'ar' => __( 'Arabic', 'pixerex-elementor-elements'),
                'eu' => __( 'Basque', 'pixerex-elementor-elements'),
                'bg' => __( 'Bulgarian', 'pixerex-elementor-elements'),
                'bn' => __( 'Bengali', 'pixerex-elementor-elements'),
                'ca' => __( 'Catalan', 'pixerex-elementor-elements'),
                'cs' => __( 'Czech', 'pixerex-elementor-elements'),
                'da' => __( 'Danish', 'pixerex-elementor-elements'),
                'de' => __( 'German', 'pixerex-elementor-elements'),
                'el' => __( 'Greek', 'pixerex-elementor-elements'),
                'en' => __( 'English', 'pixerex-elementor-elements'),
                'en-AU' => __( 'English (australian)', 'pixerex-elementor-elements'),
                'en-GB' => __( 'English (great britain)', 'pixerex-elementor-elements'),
                'es' => __( 'Spanish', 'pixerex-elementor-elements'),
                'fa' => __( 'Farsi', 'pixerex-elementor-elements'),
                'fi' => __( 'Finnish', 'pixerex-elementor-elements'),
                'fil' => __( 'Filipino', 'pixerex-elementor-elements'),
                'fr' => __( 'French', 'pixerex-elementor-elements'),
                'gl' => __( 'Galician', 'pixerex-elementor-elements'),
                'gu' => __( 'Gujarati', 'pixerex-elementor-elements'),
                'hi' => __( 'Hindi', 'pixerex-elementor-elements'),
                'hr' => __( 'Croatian', 'pixerex-elementor-elements'),
                'hu' => __( 'Hungarian', 'pixerex-elementor-elements'),
                'id' => __( 'Indonesian', 'pixerex-elementor-elements'),
                'it' => __( 'Italian', 'pixerex-elementor-elements'),
                'iw' => __( 'Hebrew', 'pixerex-elementor-elements'),
                'ja' => __( 'Japanese', 'pixerex-elementor-elements'),
                'kn' => __( 'Kannada', 'pixerex-elementor-elements'),
                'ko' => __( 'Korean', 'pixerex-elementor-elements'),
                'lt' => __( 'Lithuanian', 'pixerex-elementor-elements'),
                'lv' => __( 'Latvian', 'pixerex-elementor-elements'),
                'ml' => __( 'Malayalam', 'pixerex-elementor-elements'),
                'mr' => __( 'Marathi', 'pixerex-elementor-elements'),
                'nl' => __( 'Dutch', 'pixerex-elementor-elements'),
                'no' => __( 'Norwegian', 'pixerex-elementor-elements'),
                'pl' => __( 'Polish', 'pixerex-elementor-elements'),
                'pt' => __( 'Portuguese', 'pixerex-elementor-elements'),
                'pt-BR' => __( 'Portuguese (brazil)', 'pixerex-elementor-elements'),
                'pt-PT' => __( 'Portuguese (portugal)', 'pixerex-elementor-elements'),
                'ro' => __( 'Romanian', 'pixerex-elementor-elements'),
                'ru' => __( 'Russian', 'pixerex-elementor-elements'),
                'sk' => __( 'Slovak', 'pixerex-elementor-elements'),
                'sl' => __( 'Slovenian', 'pixerex-elementor-elements'),
                'sr' => __( 'Serbian', 'pixerex-elementor-elements'),
                'sv' => __( 'Swedish', 'pixerex-elementor-elements'),
                'tl' => __( 'Tagalog', 'pixerex-elementor-elements'),
                'ta' => __( 'Tamil', 'pixerex-elementor-elements'),
                'te' => __( 'Telugu', 'pixerex-elementor-elements'),
                'th' => __( 'Thai', 'pixerex-elementor-elements'),
                'tr' => __( 'Turkish', 'pixerex-elementor-elements'),
                'uk' => __( 'Ukrainian', 'pixerex-elementor-elements'),
                'vi' => __( 'Vietnamese', 'pixerex-elementor-elements'),
                'zh-CN' => __( 'Chinese (simplified)', 'pixerex-elementor-elements'),
                'zh-TW' => __( 'Chinese (traditional)', 'pixerex-elementor-elements'),
			);
		}

		return self::$google_localize;
        
    }
    
    /**
     * Checks if a plugin is installed
     * 
     * @since 1.0.0
     * @return boolean
     * 
     */
    public static function is_plugin_installed( $plugin_path ) {
        
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        
        $plugins = get_plugins();
        
        return isset( $plugins[ $plugin_path ] );
    }
    
    /**
	 * Check is script debug mode enabled.
	 *
	 * @since 3.11.1
	 *
	 * @return boolean is debug mode enabled
	 */
	public static function is_debug_enabled() {

		if ( null === self::$script_debug ) {

			self::$script_debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		}

		return self::$script_debug;
	}
    
    /**
	 * Get JS scripts directory.
	 *
	 * @since 0.0.1
	 *
	 * @return string JS scripts directory.
	 */
	public static function get_scripts_dir() {

		if ( null === self::$js_dir ) {

			self::$js_dir = self::is_debug_enabled() ? 'js' : 'min-js';
		}

		return self::$js_dir;
	}
    
    /**
	 * Get CSS files directory.
	 *
	 * @since 0.0.1
	 *
	 * @return string CSS files directory.
	 */
	public static function get_styles_dir() {

		if ( null === self::$css_dir ) {

			self::$css_dir = self::is_debug_enabled() ? 'css' : 'min-css';
		}

		return self::$css_dir;
	}

	/**
	 * Get JS scripts suffix.
	 *
	 * @since 0.0.1
	 *
	 * @return string JS scripts suffix.
	 */
	public static function get_assets_suffix() {

		if ( null === self::$assets_suffix ) {

			self::$assets_suffix = self::is_debug_enabled() ? '' : '.min';
		}

		return self::$assets_suffix;
	}
    
    /**
     * Get Installed Theme
     * 
     * Returns the active theme slug
     * 
     * @access public
     * @return string theme slug
     */
    public static function get_installed_theme() {

        $theme = wp_get_theme();

        if( $theme->parent() ) {

            $theme_name = $theme->parent()->get('Name');

        } else {

            $theme_name = $theme->get('Name');

        }

        $theme_name = sanitize_key( $theme_name );

        return $theme_name;
    }
    
    /*
     * Get Vimeo Video Data
     * 
     * Get video data using Vimeo API
     * 
     * @since 3.11.4
     * @access public
     * 
     * @param string $id video ID
     */
    public static function get_vimeo_video_data( $id ) {
        
        $vimeo_data         = wp_remote_get( 'http://www.vimeo.com/api/v2/video/' . intval( $id ) . '.php' );
        
        if ( isset( $vimeo_data['response']['code'] ) && '200' == $vimeo_data['response']['code'] ) {
            $response       = unserialize( $vimeo_data['body'] );
            $thumbnail = isset( $response[0]['thumbnail_large'] ) ? $response[0]['thumbnail_large'] : false;
            
            $data = [
                'src'       => $thumbnail,
                'url'       => $response[0]['user_url'],
                'portrait'  => $response[0]['user_portrait_huge'],
                'title'     => $response[0]['title'],
                'user'      => $response[0]['user_name']
            ];
            
            return $data;
        }
        
        return false;
        
    }
    
    /*
     * Get Video Thumbnail
     * 
     * Get thumbnail URL for embed or self hosted
     * 
     * @since 3.7.0
     * @access public
     * 
     * @param string $id video ID
     * @param string $type embed type
     * @param string $size youtube thumbnail size
     */
    public static function get_video_thumbnail( $id, $type, $size = '' ) {
        
        $thumbnail_src = '';
        
        if ( 'youtube' === $type ) {
            if ( '' === $size ) {
                $size = 'maxresdefault';
            }
            $thumbnail_src = sprintf( 'https://i.ytimg.com/vi/%s/%s.jpg', $id, $size );
        } elseif ( 'vimeo' === $type ) {
           
            $vimeo = self::get_vimeo_video_data( $id );
            
            $thumbnail_src = $vimeo['src'];
                
        } else {
            $thumbnail_src = 'transparent';
        }
        
        return $thumbnail_src;
    }
}