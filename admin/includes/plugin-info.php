<?php

namespace PixerexAddons\Admin\Includes;

use PixerexAddons\Helper_Functions;

if ( ! defined( 'ABSPATH' ) ) exit;

class Plugin_Info {

    public function create_about_menu() {
        
        if ( ! Helper_Functions::is_hide_about() ) {
                add_submenu_page(
                'pixerex-addons',
                '',
                __('About','pixerex-addons-for-elementor'),
                'manage_options',
                'pixerex-addons-about',
                [ $this, 'pa_about_page' ]
            );
        }
        
    }

	public function pa_about_page() {
        
        $theme_name = Helper_Functions::get_installed_theme();
        
        $url = sprintf('https://pixerexaddons.com/pro/?utm_source=about-page&utm_medium=wp-dash&utm_campaign=get-pro&utm_term=%s', $theme_name );
        
        $support_url = sprintf('https://pixerexaddons.com/support/?utm_source=about-page&utm_medium=wp-dash&utm_campaign=get-support&utm_term=%s', $theme_name );
        
        ?>
        <div class="wrap">
           <div class="response-wrap"></div>
           <div class="pa-header-wrapper">
              <div class="pa-title-left">
                 <h1 class="pa-title-main"><?php echo Helper_Functions::name(); ?></h1>
                 <h3 class="pa-title-sub"><?php echo sprintf(__('Thank you for using %s. This plugin has been developed by %s and we hope you enjoy using it.','pixerex-addons-for-elementor'), Helper_Functions::name(),Helper_Functions::author()); ?></h3>
              </div>
              <?php if( ! Helper_Functions::is_hide_logo() ) : ?>
                <div class="pa-title-right">
                    <img class="pa-logo" src="<?php echo pixerex_ADDONS_URL . 'admin/images/pixerex-addons-logo.png';?>">
                </div>
                <?php endif; ?>
           </div>
           <div class="pa-settings-tabs">
              <div id="pa-about" class="pa-settings-tab">
                 <div class="pa-row">
                    <div class="pa-col-half">
                       <div class="pa-about-panel">
                          <div class="pa-icon-container">
                             <i class="dashicons dashicons-info abt-icon-style"></i>
                          </div>
                          <div class="pa-text-container">
                             <h4><?php echo __('What is Pixerex Addons?', 'pixerex-addons-for-elementor'); ?></h4>
                             <p><?php echo __('Pixerex Addons for Elementor extends Elementor Page Builder capabilities with many fully customizable widgets and addons that help you to build impressive websites with no coding required.', 'pixerex-addons-for-elementor'); ?></p>
                             <?php if( ! defined('PIXEREX_PRO_ADDONS_VERSION') ) : ?>
                                <p><?php echo __('Get more widgets and addons with ', 'pixerex-addons-for-elementor'); ?><strong><?php echo __('Pixerex Addons Pro', 'pixerex-addons-for-elementor'); ?></strong> <a href="<?php echo esc_url( $url ); ?>" target="_blank" ><?php echo __('Click Here', 'pixerex-addons-for-elementor'); ?></a><?php echo __(' to know more.', 'pixerex-addons-for-elementor'); ?></p>
                             <?php endif; ?>
                          </div>
                       </div>
                    </div>
                    <div class="pa-col-half">
                       <div class="pa-about-panel">
                          <div class="pa-icon-container">
                             <i class="dashicons dashicons-universal-access-alt abt-icon-style"></i>
                          </div>
                          <div class="pa-text-container">
                             <h4><?php echo __('Docs and Support', 'pixerex-addons-for-elementor'); ?></h4>
                             <p><?php echo __('It’s highly recommended to check out documentation and FAQ before using this plugin. ', 'pixerex-addons-for-elementor'); ?><a target="_blank" href="<?php echo esc_url( $support_url ); ?>"><?php echo __('Click Here', 'pixerex-addons-for-elementor'); ?></a><?php echo __(' for more details. You can also join our ', 'pixerex-addons-for-elementor'); ?><a href="https://www.facebook.com/groups/pixerexAddons" target="_blank"><?php echo __('Facebook Group', 'pixerex-addons-for-elementor'); ?></a><?php echo __(' and Our ', 'pixerex-addons-for-elementor'); ?><a href="https://my.leap13.com/forums/" target="_blank"><?php echo __('Community Forums', 'pixerex-addons-for-elementor'); ?></a></p>
                          </div>
                       </div>
                    </div>
                 </div>
                <?php if( ! Helper_Functions::is_hide_rate() ) : ?>
                    <div>
                        <p><?php echo __('Did you like Pixerex Addons for Elementor Plugin? Please ', 'pixerex-addons-for-elementor'); ?><a href="https://wordpress.org/support/plugin/pixerex-addons-for-elementor/reviews/#new-post" target="_blank"><?php echo __('Click Here to Rate it ★★★★★', 'pixerex-addons-for-elementor'); ?></a></p>
                    </div>
                <?php endif; ?>
              </div>
           </div>
        </div>
    <?php }
    
	public function __construct() {
        add_action( 'admin_menu', array ($this,'create_about_menu' ), 100 );
	}    
}