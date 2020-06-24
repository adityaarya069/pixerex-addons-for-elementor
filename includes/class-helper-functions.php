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
    public static function is_hide_rate() {
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if( isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-rate'] ) ) {
                $hide_rate = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-rate'];
            }
        }
        
        return isset( $hide_rate ) ? $hide_rate : false;
    }
    
    /**
     * Check if white labeling - hide about page is checked
     * 
     * @since 1.0.0
     * @return boolean
     * 
     */
    public static function is_hide_about() {
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-about'])){
                $hide_about = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-about'];
            }
        }
        
        return isset( $hide_about ) ? $hide_about : false;
    }
    
    /**
     * Check if white labeling - hide version control page is checked
     * 
     * @since 1.0.0
     * @return boolean
     * 
     */
    public static function is_hide_version_control() {
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
                if(isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-version'])){
                    $hide_version_tab = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-version'];
            }
        }
        
        return isset( $hide_version_tab ) ? $hide_version_tab : false;
    }
    
    /**
     * Check if white labeling - Free version author field is set
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function author() {
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-name'])){
                $author_free = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-name'];
            }
        }
        
        return ( isset( $author_free ) && '' != $author_free ) ? $author_free : 'Team Pixerex';
    }
    
    /**
     * Check if white labeling - Free version name field is set
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function name() {
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-plugin-name'])){
                $name_free = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-plugin-name'];
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
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if( isset( get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-row'] ) ){
                $hide_meta = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-row'];
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
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-logo'])){
                $hide_logo = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-logo'];
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
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-short-name'])){
                $category = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-short-name'];
            }
        }
        
        return ( isset( $category ) && '' != $category ) ? $category : __( 'Pixerex Addons', 'pixerex-addons-for-elementor' );
        
    }
    
    /**
     * Get White Labeling - Widgets Prefix string
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_prefix() {
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-prefix'])){
                $prefix = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-prefix'];
            }
        }
        
        return ( isset( $prefix ) && '' != $prefix ) ? $prefix : __('Pixerex', 'pixerex-addons-for-elementor');
    }
    
    /**
     * Get White Labeling - Widgets Badge string
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_badge() {
        
        if( defined('PREMIUM_PRO_ADDONS_VERSION') ) {
            if(isset(get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-badge'])){
                $badge = get_option('pa_wht_lbl_save_settings')['pixerex-wht-lbl-badge'];
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
				 'ar' => __( 'Arabic', 'pixerex-addons-for-elementor'),
                'eu' => __( 'Basque', 'pixerex-addons-for-elementor'),
                'bg' => __( 'Bulgarian', 'pixerex-addons-for-elementor'),
                'bn' => __( 'Bengali', 'pixerex-addons-for-elementor'),
                'ca' => __( 'Catalan', 'pixerex-addons-for-elementor'),
                'cs' => __( 'Czech', 'pixerex-addons-for-elementor'),
                'da' => __( 'Danish', 'pixerex-addons-for-elementor'),
                'de' => __( 'German', 'pixerex-addons-for-elementor'),
                'el' => __( 'Greek', 'pixerex-addons-for-elementor'),
                'en' => __( 'English', 'pixerex-addons-for-elementor'),
                'en-AU' => __( 'English (australian)', 'pixerex-addons-for-elementor'),
                'en-GB' => __( 'English (great britain)', 'pixerex-addons-for-elementor'),
                'es' => __( 'Spanish', 'pixerex-addons-for-elementor'),
                'fa' => __( 'Farsi', 'pixerex-addons-for-elementor'),
                'fi' => __( 'Finnish', 'pixerex-addons-for-elementor'),
                'fil' => __( 'Filipino', 'pixerex-addons-for-elementor'),
                'fr' => __( 'French', 'pixerex-addons-for-elementor'),
                'gl' => __( 'Galician', 'pixerex-addons-for-elementor'),
                'gu' => __( 'Gujarati', 'pixerex-addons-for-elementor'),
                'hi' => __( 'Hindi', 'pixerex-addons-for-elementor'),
                'hr' => __( 'Croatian', 'pixerex-addons-for-elementor'),
                'hu' => __( 'Hungarian', 'pixerex-addons-for-elementor'),
                'id' => __( 'Indonesian', 'pixerex-addons-for-elementor'),
                'it' => __( 'Italian', 'pixerex-addons-for-elementor'),
                'iw' => __( 'Hebrew', 'pixerex-addons-for-elementor'),
                'ja' => __( 'Japanese', 'pixerex-addons-for-elementor'),
                'kn' => __( 'Kannada', 'pixerex-addons-for-elementor'),
                'ko' => __( 'Korean', 'pixerex-addons-for-elementor'),
                'lt' => __( 'Lithuanian', 'pixerex-addons-for-elementor'),
                'lv' => __( 'Latvian', 'pixerex-addons-for-elementor'),
                'ml' => __( 'Malayalam', 'pixerex-addons-for-elementor'),
                'mr' => __( 'Marathi', 'pixerex-addons-for-elementor'),
                'nl' => __( 'Dutch', 'pixerex-addons-for-elementor'),
                'no' => __( 'Norwegian', 'pixerex-addons-for-elementor'),
                'pl' => __( 'Polish', 'pixerex-addons-for-elementor'),
                'pt' => __( 'Portuguese', 'pixerex-addons-for-elementor'),
                'pt-BR' => __( 'Portuguese (brazil)', 'pixerex-addons-for-elementor'),
                'pt-PT' => __( 'Portuguese (portugal)', 'pixerex-addons-for-elementor'),
                'ro' => __( 'Romanian', 'pixerex-addons-for-elementor'),
                'ru' => __( 'Russian', 'pixerex-addons-for-elementor'),
                'sk' => __( 'Slovak', 'pixerex-addons-for-elementor'),
                'sl' => __( 'Slovenian', 'pixerex-addons-for-elementor'),
                'sr' => __( 'Serbian', 'pixerex-addons-for-elementor'),
                'sv' => __( 'Swedish', 'pixerex-addons-for-elementor'),
                'tl' => __( 'Tagalog', 'pixerex-addons-for-elementor'),
                'ta' => __( 'Tamil', 'pixerex-addons-for-elementor'),
                'te' => __( 'Telugu', 'pixerex-addons-for-elementor'),
                'th' => __( 'Thai', 'pixerex-addons-for-elementor'),
                'tr' => __( 'Turkish', 'pixerex-addons-for-elementor'),
                'uk' => __( 'Ukrainian', 'pixerex-addons-for-elementor'),
                'vi' => __( 'Vietnamese', 'pixerex-addons-for-elementor'),
                'zh-CN' => __( 'Chinese (simplified)', 'pixerex-addons-for-elementor'),
                'zh-TW' => __( 'Chinese (traditional)', 'pixerex-addons-for-elementor'),
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