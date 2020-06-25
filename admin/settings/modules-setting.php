<?php

namespace PixerexAddons\Admin\Settings;

use PixerexAddons\Helper_Functions;

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class Modules_Settings {
    
    protected $page_slug = 'pixerex-addons';

    public static $pa_elements_keys = [
	'pixerex-banner', 
	'pixerex-blog',
	'pixerex-carousel', 
	'pixerex-countdown', 
	'pixerex-counter', 
	'pixerex-dual-header',
	'pixerex-lottie', 
	'pixerex-maps', 
	'pixerex-modalbox',
	'pixerex-progressbar', 
	'pixerex-pricing-table', 
	'pixerex-button',
	'pixerex-contactform', 
	'pixerex-image-button', 
	'pixerex-grid', 
	'pixerex-image-scroll',
	'pixerex-templates',
	'pixerex-duplicator'];
    
    private $pa_default_settings;
    
    private $pa_settings;
    
    private $pa_get_settings;
   
    public function __construct() {
        
        add_action( 'admin_menu', array( $this,'pa_admin_menu') );
        
        add_action( 'admin_enqueue_scripts', array( $this, 'pa_admin_page_scripts' ) );
        
        add_action( 'wp_ajax_pa_save_admin_addons_settings', array( $this, 'pa_save_settings' ) );
        
        add_action( 'admin_enqueue_scripts',array( $this, 'localize_js_script' ) );
        
    }
    
    public function localize_js_script(){
        wp_localize_script(
            'pa-admin-js',
            'pixerexRollBackConfirm',
            [
                'home_url'  => home_url(),
                'i18n' => [
					'rollback_confirm' => __( 'Are you sure you want to reinstall version ' . PIXEREX_ADDONS_STABLE_VERSION . ' ?', 'pixerex-elementor-elements' ),
					'rollback_to_previous_version' => __( 'Rollback to Previous Version', 'pixerex-elementor-elements' ),
					'yes' => __( 'Yes', 'pixerex-elementor-elements' ),
					'cancel' => __( 'Cancel', 'pixerex-elementor-elements' ),
				],
            ]
            );
    }

    public function pa_admin_page_scripts () {
        
        wp_enqueue_style( 'pa_admin_icon', PIXEREX_ADDONS_URL .'admin/assets/fonts/style.css' );
        
        $suffix = is_rtl() ? '-rtl' : '';
        
        $current_screen = get_current_screen();
        
        wp_enqueue_style(
            'pa-notice-css',
            PIXEREX_ADDONS_URL . 'admin/assets/css/notice' . $suffix . '.css'
        );
        
        if( strpos( $current_screen->id , $this->page_slug ) !== false ) {
            
            wp_enqueue_style(
                'pa-admin-css',
                PIXEREX_ADDONS_URL.'admin/assets/css/admin' . $suffix . '.css'
            );
            
            wp_enqueue_style(
                'pa-sweetalert-style',
                PIXEREX_ADDONS_URL . 'admin/assets/js/sweetalert2/sweetalert2.min.css'
            );
            
            wp_enqueue_script(
                'pa-admin-js',
                PIXEREX_ADDONS_URL .'admin/assets/js/admin.js',
                array('jquery'),
                PIXEREX_ADDONS_VERSION,
                true
            );
            
            wp_enqueue_script(
                'pa-admin-dialog',
                PIXEREX_ADDONS_URL . 'admin/assets/js/dialog/dialog.js',
                array('jquery-ui-position'),
                PIXEREX_ADDONS_VERSION,
                true
            );
            
            wp_enqueue_script(
                'pa-sweetalert-core',
                PIXEREX_ADDONS_URL . 'admin/assets/js/sweetalert2/core.js',
                array('jquery'),
                PIXEREX_ADDONS_VERSION,
                true
            );
            
			wp_enqueue_script(
                'pa-sweetalert',
                PIXEREX_ADDONS_URL . 'admin/assets/js/sweetalert2/sweetalert2.min.js',
                array( 'jquery', 'pa-sweetalert-core' ),
                PIXEREX_ADDONS_VERSION,
                true
            );
            
        }
    }

    public function pa_admin_menu() {
        
        $plugin_name = 'Pixerex Addons for Elementor';
        
        if( defined( 'PIXEREX_PRO_ADDONS_VERSION' ) ) {
            if( isset( get_option( 'pa_wht_lbl_save_settings' )['pixerex-wht-lbl-plugin-name'] ) ) {
                $name = get_option( 'pa_wht_lbl_save_settings' )['pixerex-wht-lbl-plugin-name'];
                if( '' !== $name )
                    $plugin_name = $name;
            }
            
        }
        
        add_menu_page(
            $plugin_name,
            $plugin_name,
            'manage_options',
            'pixerex-addons',
            array( $this , 'pa_admin_page' ),
            '' ,
            100
        );
    }

    public function pa_admin_page() {
        
        $theme_slug = Helper_Functions::get_installed_theme();
        
        $js_info = array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'nonce' 	=> wp_create_nonce( 'pa-elements' ),
            'theme'     => $theme_slug
		);

		wp_localize_script( 'pa-admin-js', 'settings', $js_info );
        
        $this->pa_default_settings = $this->get_default_keys();
       
        $this->pa_get_settings = $this->get_enabled_keys();
       
        $pa_new_settings = array_diff_key( $this->pa_default_settings, $this->pa_get_settings );
       
        if( ! empty( $pa_new_settings ) ) {
            $pa_updated_settings = array_merge( $this->pa_get_settings, $pa_new_settings );
            update_option( 'pa_save_settings', $pa_updated_settings );
        }
        $this->pa_get_settings = get_option( 'pa_save_settings', $this->pa_default_settings );
        
        $prefix = Helper_Functions::get_prefix();
        
	?>
	<div class="wrap">
        <div class="response-wrap"></div>
        <form action="" method="POST" id="pa-settings" name="pa-settings">
            <div class="pa-header-wrapper">
                <div class="pa-title-left">
                    <h1 class="pa-title-main"><?php echo Helper_Functions::name(); ?></h1>
                    <h3 class="pa-title-sub"><?php echo sprintf(__('Thank you for using %s. This plugin has been developed by %s and we hope you enjoy using it.','pixerex-elementor-elements'), Helper_Functions::name(), Helper_Functions::author() ); ?></h3>
                </div>
                <?php if( ! Helper_Functions::is_hide_logo() ) : ?>
                <div class="pa-title-right">
                    <img class="pa-logo" src="<?php echo PIXEREX_ADDONS_URL . 'admin/images/pixerex-addons-logo.png';?>">
                </div>
                <?php endif; ?>
            </div>
            <div class="pa-settings-tabs">
                <div id="pa-modules" class="pa-settings-tab">
                    <div>
                        <br>
                        <input type="checkbox" class="pa-checkbox" checked="checked">
                        <label>Enable/Disable All</label>
                    </div>
                    <table class="pa-elements-table">
                        <tbody>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Banner', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-banner" name="pixerex-banner" <?php checked(1, $this->pa_get_settings['pixerex-banner'], true) ?>>
                                        <span class="slider round"></span>
                                </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Blog', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-blog" name="pixerex-blog" <?php checked(1, $this->pa_get_settings['pixerex-blog'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Button', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-button" name="pixerex-button" <?php checked(1, $this->pa_get_settings['pixerex-button'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Carousel', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-carousel" name="pixerex-carousel" <?php checked(1, $this->pa_get_settings['pixerex-carousel'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Contact Form7', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-contactform" name="pixerex-contactform" <?php checked(1, $this->pa_get_settings['pixerex-contactform'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Countdown', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-countdown" name="pixerex-countdown" <?php checked(1, $this->pa_get_settings['pixerex-countdown'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Counter', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-counter" name="pixerex-counter" <?php checked(1, $this->pa_get_settings['pixerex-counter'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Dual Heading', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-dual-header" name="pixerex-dual-header" <?php checked(1, $this->pa_get_settings['pixerex-dual-header'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                               
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Media Grid', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-grid" name="pixerex-grid" <?php checked(1, $this->pa_get_settings['pixerex-grid'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
								<th><?php echo sprintf( '%1$s %2$s', $prefix, __('Image Scroll', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-image-scroll" name="pixerex-image-scroll" <?php checked(1, $this->pa_get_settings['pixerex-image-scroll'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Image Button', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-image-button" name="pixerex-image-button" <?php checked(1, $this->pa_get_settings['pixerex-image-button'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                               <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Modal Box', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-modalbox" name="pixerex-modalbox" <?php checked(1, $this->pa_get_settings['pixerex-modalbox'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td> 
                            </tr>
                            
                            <tr>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Lottie Animations', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-lottie" name="pixerex-lottie" <?php checked(1, $this->pa_get_settings['pixerex-lottie'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
								
								
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Templates', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-templates" name="pixerex-templates" <?php checked(1, $this->pa_get_settings['pixerex-templates'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Maps', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-maps" name="pixerex-maps" <?php checked(1, $this->pa_get_settings['pixerex-maps'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                

                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Progress Bar', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-progressbar" name="pixerex-progressbar" <?php checked(1, $this->pa_get_settings['pixerex-progressbar'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>                                
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Pricing Table', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-pricing-table" name="pixerex-pricing-table" <?php checked(1, $this->pa_get_settings['pixerex-pricing-table'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>

                                
                            </tr>
                            
                            <tr>
                                

                              
                            </tr>

                            <tr>
                                
                            </tr>
                            
                            <tr>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Duplicator', 'pixerex-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-duplicator" name="pixerex-duplicator" <?php checked(1, $this->pa_get_settings['pixerex-duplicator'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                            </tr>

                            

                            <?php if( ! defined( 'pixerex_PRO_ADDONS_VERSION' ) ) : ?> 
                           <!-- Removed All Pro Widgets -->
                            <?php endif; ?> 
                        </tbody>
                    </table>
                    <input type="submit" value="<?php echo __('Save Settings', 'pixerex-elementor-elements'); ?>" class="button pa-btn pa-save-button">
                    
                </div>
                
            </div>
            </form>
        </div>
	<?php
}

    public static function get_default_keys() {
        
        $default_keys = array_fill_keys( self::$pa_elements_keys, true );
        
        return $default_keys;
    }
    
    public static function get_enabled_keys() {
        
        $enabled_keys = get_option( 'pa_save_settings', self::get_default_keys() );
        
        return $enabled_keys;
    }
    
    /*
     * Check If Pixerex Templates is enabled
     * 
     * @since 3.6.0
     * @access public
     * 
     * @return boolean
     */
    public static function check_pixerex_templates() {
        
        $settings = self::get_enabled_keys();
        
        if( ! isset( $settings['pixerex-templates'] ) )
            return true;

        $is_enabled = $settings['pixerex-templates'];
        
        return $is_enabled;
    }
    
    /*
     * Check If Pixerex Duplicator is enabled
     * 
     * @since 3.9.7
     * @access public
     * 
     * @return boolean
     */
    public static function check_pixerex_duplicator() {
        
        $settings = self::get_enabled_keys();
        
        if( ! isset( $settings['pixerex-duplicator'] ) )
            return true;

        $is_enabled = $settings['pixerex-duplicator'];
        
        return $is_enabled;
    }

    public function pa_save_settings() {
        
        check_ajax_referer( 'pa-elements', 'security' );

        if( isset( $_POST['fields'] ) ) {
            parse_str( $_POST['fields'], $settings );
        } else {
            return;
        }

         $this->pa_settings = array(
            'pixerex-banner'            => intval( $settings['pixerex-banner'] ? 1 : 0 ),
            'pixerex-blog'              => intval( $settings['pixerex-blog'] ? 1 : 0 ),
            'pixerex-carousel'          => intval( $settings['pixerex-carousel'] ? 1 : 0 ),
            'pixerex-countdown'         => intval( $settings['pixerex-countdown'] ? 1 : 0 ),
            'pixerex-counter'           => intval( $settings['pixerex-counter'] ? 1 : 0 ),
            'pixerex-dual-header'       => intval( $settings['pixerex-dual-header'] ? 1 : 0 ),
            'pixerex-fancytext'         => intval( $settings['pixerex-fancytext'] ? 1 : 0 ),
            'pixerex-image-separator'   => intval( $settings['pixerex-image-separator'] ? 1 : 0 ),
            'pixerex-lottie'            => intval( $settings['pixerex-lottie'] ? 1 : 0 ),
            'pixerex-maps'              => intval( $settings['pixerex-maps'] ? 1 : 0 ),
            'pixerex-modalbox' 			=> intval( $settings['pixerex-modalbox'] ? 1 : 0 ),
            'pixerex-person' 			=> intval( $settings['pixerex-person'] ? 1 : 0 ),
            'pixerex-progressbar' 		=> intval( $settings['pixerex-progressbar'] ? 1 : 0 ),
            'pixerex-testimonials' 		=> intval( $settings['pixerex-testimonials'] ? 1 : 0 ),
            'pixerex-title'             => intval( $settings['pixerex-title'] ? 1 : 0 ),
            'pixerex-pricing-table'     => intval( $settings['pixerex-pricing-table'] ? 1 : 0 ),
            'pixerex-button'            => intval( $settings['pixerex-button'] ? 1 : 0 ),
            'pixerex-contactform'       => intval( $settings['pixerex-contactform'] ? 1 : 0 ),
            'pixerex-image-button'      => intval( $settings['pixerex-image-button'] ? 1 : 0 ),
            'pixerex-grid'              => intval( $settings['pixerex-grid'] ? 1 : 0 ),
            'pixerex-image-scroll'      => intval( $settings['pixerex-image-scroll'] ? 1 : 0 ),
            'pixerex-templates'         => intval( $settings['pixerex-templates'] ? 1 : 0 ),
            'pixerex-duplicator'        => intval( $settings['pixerex-duplicator'] ? 1 : 0 ),
        );

        update_option( 'pa_save_settings', $this->pa_settings );

        return true;
    }
	


}