<?php

namespace PixerexAddons\Admin\Settings;

use PixerexAddons\Helper_Functions;

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class Modules_Settings {
    
    protected $page_slug = 'pixerex-addons';

    public static $pr_elements_keys = ['premium-banner', 
	'premium-blog',
	'premium-carousel', 
	'premium-countdown', 
	'premium-counter', 
	'premium-dual-header',
	'premium-lottie', 
	'premium-maps', 
	'premium-modalbox',
	'premium-progressbar', 
	'premium-pricing-table', 
	'premium-button',
	'premium-contactform', 
	'premium-image-button', 
	'premium-grid', 
	'premium-image-scroll',
	'premium-templates',
	'premium-duplicator'];
    
    private $pr_default_settings;
    
    private $pr_settings;
    
    private $pr_get_settings;
   
    public function __construct() {
        
        add_action( 'admin_menu', array( $this,'pr_admin_menu') );
        
        add_action( 'admin_enqueue_scripts', array( $this, 'pr_admin_page_scripts' ) );
        
        add_action( 'wp_ajax_pr_save_admin_addons_settings', array( $this, 'pr_save_settings' ) );
        
        add_action( 'admin_enqueue_scripts',array( $this, 'localize_js_script' ) );
        
    }
    
    public function localize_js_script(){
        wp_localize_script(
            'pr-admin-js',
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

    public function pr_admin_page_scripts () {
        
        wp_enqueue_style( 'pr_admin_icon', PIXEREX_ADDONS_URL .'admin/assets/fonts/style.css' );
        
        $suffix = is_rtl() ? '-rtl' : '';
        
        $current_screen = get_current_screen();
        
        wp_enqueue_style(
            'pr-notice-css',
            PIXEREX_ADDONS_URL . 'admin/assets/css/notice' . $suffix . '.css'
        );
        
        if( strpos( $current_screen->id , $this->page_slug ) !== false ) {
            
            wp_enqueue_style(
                'pr-admin-css',
                PIXEREX_ADDONS_URL.'admin/assets/css/admin' . $suffix . '.css'
            );
            
            wp_enqueue_style(
                'pr-sweetalert-style',
                PIXEREX_ADDONS_URL . 'admin/assets/js/sweetalert2/sweetalert2.min.css'
            );
            
            wp_enqueue_script(
                'pr-admin-js',
                PIXEREX_ADDONS_URL .'admin/assets/js/admin.js',
                array('jquery'),
                PIXEREX_ADDONS_VERSION,
                true
            );
            
            wp_enqueue_script(
                'pr-admin-dialog',
                PIXEREX_ADDONS_URL . 'admin/assets/js/dialog/dialog.js',
                array('jquery-ui-position'),
                PIXEREX_ADDONS_VERSION,
                true
            );
            
            wp_enqueue_script(
                'pr-sweetalert-core',
                PIXEREX_ADDONS_URL . 'admin/assets/js/sweetalert2/core.js',
                array('jquery'),
                PIXEREX_ADDONS_VERSION,
                true
            );
            
			wp_enqueue_script(
                'pr-sweetalert',
                PIXEREX_ADDONS_URL . 'admin/assets/js/sweetalert2/sweetalert2.min.js',
                array( 'jquery', 'pr-sweetalert-core' ),
                PIXEREX_ADDONS_VERSION,
                true
            );
            
        }
    }

    public function pr_admin_menu() {
        
        $plugin_name = 'Pixerex Addons for Elementor';
        
        if( defined( 'PIXEREX_PRO_ADDONS_VERSION' ) ) {
            if( isset( get_option( 'pr_wht_lbl_save_settings' )['pixerex-wht-lbl-plugin-name'] ) ) {
                $name = get_option( 'pr_wht_lbl_save_settings' )['pixerex-wht-lbl-plugin-name'];
                if( '' !== $name )
                    $plugin_name = $name;
            }
            
        }
        
        add_menu_page(
            $plugin_name,
            $plugin_name,
            'manage_options',
            'pixerex-addons',
            array( $this , 'pr_admin_page' ),
            '' ,
            100
        );
    }

    public function pr_admin_page() {
        
        $theme_slug = Helper_Functions::get_installed_theme();
        
        $js_info = array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'nonce' 	=> wp_create_nonce( 'pr-elements' ),
            'theme'     => $theme_slug
		);

		wp_localize_script( 'pr-admin-js', 'settings', $js_info );
        
        $this->pr_default_settings = $this->get_default_keys();
       
        $this->pr_get_settings = $this->get_enabled_keys();
       
        $pr_new_settings = array_diff_key( $this->pr_default_settings, $this->pr_get_settings );
       
        if( ! empty( $pr_new_settings ) ) {
            $pr_updated_settings = array_merge( $this->pr_get_settings, $pr_new_settings );
            update_option( 'pr_save_settings', $pr_updated_settings );
        }
        $this->pr_get_settings = get_option( 'pr_save_settings', $this->pr_default_settings );
        
        $prefix = Helper_Functions::get_prefix();
        
	?>
	<div class="wrap">
        <div class="response-wrap"></div>
        <form action="" method="POST" id="pr-settings" name="pr-settings">
            <div class="pr-header-wrapper">
                <div class="pr-title-left">
                    <h1 class="pr-title-main"><?php echo Helper_Functions::name(); ?></h1>
                    <h3 class="pr-title-sub"><?php echo sprintf(__('Thank you for using %s. This plugin has been developed by %s and we hope you enjoy using it.','pixerex-elementor-elements'), Helper_Functions::name(), Helper_Functions::author() ); ?></h3>
                </div>
                <?php if( ! Helper_Functions::is_hide_logo() ) : ?>
                <div class="pr-title-right">
                    <img class="pr-logo" src="<?php echo PIXEREX_ADDONS_URL . 'admin/images/pixerex-addons-logo.png';?>">
                </div>
                <?php endif; ?>
            </div>
            <div class="pr-settings-tabs">
                <div id="pr-modules" class="pr-settings-tab">
                    <div>
                        <br>
                        <input type="checkbox" class="pr-checkbox" checked="checked">
                        <label>Enable/Disable All</label>
                    </div>
                    <table class="pr-elements-table">
                        <tbody>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Banner', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="premium-banner" name="premium-banner" <?php checked(1, $this->pr_get_settings['premium-banner'], true) ?>>
                                        <span class="slider round"></span>
                                </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Blog', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-blog" name="premium-blog" <?php checked(1, $this->pr_get_settings['premium-blog'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Button', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-button" name="premium-button" <?php checked(1, $this->pr_get_settings['premium-button'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Carousel', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-carousel" name="premium-carousel" <?php checked(1, $this->pr_get_settings['premium-carousel'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Contact Form7', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-contactform" name="premium-contactform" <?php checked(1, $this->pr_get_settings['premium-contactform'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Countdown', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-countdown" name="premium-countdown" <?php checked(1, $this->pr_get_settings['premium-countdown'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Counter', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-counter" name="premium-counter" <?php checked(1, $this->pr_get_settings['premium-counter'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Dual Heading', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-dual-header" name="premium-dual-header" <?php checked(1, $this->pr_get_settings['premium-dual-header'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                               
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Media Grid', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-grid" name="premium-grid" <?php checked(1, $this->pr_get_settings['premium-grid'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
								<th><?php echo sprintf( '%1$s %2$s', $prefix, __('Image Scroll', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-image-scroll" name="premium-image-scroll" <?php checked(1, $this->pr_get_settings['premium-image-scroll'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Image Button', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-image-button" name="premium-image-button" <?php checked(1, $this->pr_get_settings['premium-image-button'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                               <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Modal Box', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-modalbox" name="premium-modalbox" <?php checked(1, $this->pr_get_settings['premium-modalbox'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td> 
                            </tr>
                            
                            <tr>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Lottie Animations', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-lottie" name="premium-lottie" <?php checked(1, $this->pr_get_settings['premium-lottie'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
								
								
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Templates', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-templates" name="premium-templates" <?php checked(1, $this->pr_get_settings['premium-templates'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Maps', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-maps" name="premium-maps" <?php checked(1, $this->pr_get_settings['premium-maps'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                

                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Progress Bar', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-progressbar" name="premium-progressbar" <?php checked(1, $this->pr_get_settings['premium-progressbar'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>                                
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Pricing Table', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-pricing-table" name="premium-pricing-table" <?php checked(1, $this->pr_get_settings['premium-pricing-table'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>

                                
                            </tr>
                            
                            <tr>
                                

                              
                            </tr>

                            <tr>
                                
                            </tr>
                            
                            <tr>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Duplicator', 'premium-addons-for-elementor') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="premium-duplicator" name="premium-duplicator" <?php checked(1, $this->pr_get_settings['premium-duplicator'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                            </tr>

                            

                            <?php if( ! defined( 'pixerex_PRO_ADDONS_VERSION' ) ) : ?> 
                           <!-- Removed All Pro Widgets -->
                            <?php endif; ?> 
                        </tbody>
                    </table>
                    <input type="submit" value="<?php echo __('Save Settings', 'pixerex-elementor-elements'); ?>" class="button pr-btn pr-save-button">
                    
                </div>
                
            </div>
            </form>
        </div>
	<?php
}

    public static function get_default_keys() {
        
        $default_keys = array_fill_keys( self::$pr_elements_keys, true );
        
        return $default_keys;
    }
    
    public static function get_enabled_keys() {
        
        $enabled_keys = get_option( 'pr_save_settings', self::get_default_keys() );
        
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

    public function pr_save_settings() {
        
        check_ajax_referer( 'pr-elements', 'security' );

        if( isset( $_POST['fields'] ) ) {
            parse_str( $_POST['fields'], $settings );
        } else {
            return;
        }

         $this->pr_settings = array(
            'premium-banner'            => intval( $settings['premium-banner'] ? 1 : 0 ),
            'premium-blog'              => intval( $settings['premium-blog'] ? 1 : 0 ),
            'premium-carousel'          => intval( $settings['premium-carousel'] ? 1 : 0 ),
            'premium-countdown'         => intval( $settings['premium-countdown'] ? 1 : 0 ),
            'premium-counter'           => intval( $settings['premium-counter'] ? 1 : 0 ),
            'premium-dual-header'       => intval( $settings['premium-dual-header'] ? 1 : 0 ),
            'premium-fancytext'         => intval( $settings['premium-fancytext'] ? 1 : 0 ),
            'premium-image-separator'   => intval( $settings['premium-image-separator'] ? 1 : 0 ),
            'premium-lottie'            => intval( $settings['premium-lottie'] ? 1 : 0 ),
            'premium-maps'              => intval( $settings['premium-maps'] ? 1 : 0 ),
            'premium-modalbox' 			=> intval( $settings['premium-modalbox'] ? 1 : 0 ),
            'premium-person' 			=> intval( $settings['premium-person'] ? 1 : 0 ),
            'premium-progressbar' 		=> intval( $settings['premium-progressbar'] ? 1 : 0 ),
            'premium-testimonials' 		=> intval( $settings['premium-testimonials'] ? 1 : 0 ),
            'premium-title'             => intval( $settings['premium-title'] ? 1 : 0 ),
            'premium-pricing-table'     => intval( $settings['premium-pricing-table'] ? 1 : 0 ),
            'premium-button'            => intval( $settings['premium-button'] ? 1 : 0 ),
            'premium-contactform'       => intval( $settings['premium-contactform'] ? 1 : 0 ),
            'premium-image-button'      => intval( $settings['premium-image-button'] ? 1 : 0 ),
            'premium-grid'              => intval( $settings['premium-grid'] ? 1 : 0 ),
            'premium-image-scroll'      => intval( $settings['premium-image-scroll'] ? 1 : 0 ),
            'premium-templates'         => intval( $settings['premium-templates'] ? 1 : 0 ),
            'premium-duplicator'        => intval( $settings['premium-duplicator'] ? 1 : 0 ),
        );

        update_option( 'pr_save_settings', $this->pr_settings );

        return true;
    }
}