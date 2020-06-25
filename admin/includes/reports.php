<?php

namespace PixerexAddons\Admin\Includes;

use PixerexAddons\Helper_Functions;

if( ! defined( 'ABSPATH' ) ) exit;

class Config_Data {
    
    public function __construct() {
        
       // add_action( 'admin_menu', array ($this,'create_sys_info_menu' ), 100 );
    }
    
    public function create_sys_info_menu() {
        add_submenu_page(
            'pixerex-addons',
            '',
            __( 'System Info','pixerex-elementor-elements' ),
            'manage_options',
            'pixerex-addons-sys',
            [$this, 'pr_sys_info_page']
        );
    }
    
    public function pr_sys_info_page() {
    ?>
    <div class="wrap">
        <div class="response-wrap"></div>
        <div class="pr-header-wrapper">
            <div class="pr-title-left">
                <h1 class="pr-title-main"><?php echo Helper_Functions::name(); ?></h1>
                <h3 class="pr-title-sub"><?php echo sprintf( __( 'Thank you for using %s. This plugin has been developed by %s and we hope you enjoy using it.','pixerex-elementor-elements' ), Helper_Functions::name(), Helper_Functions::author() ); ?></h3>
            </div>
            <?php if( ! Helper_Functions::is_hide_logo() ) : ?>
                <div class="pr-title-right">
                    <img class="pr-logo" src="<?php echo PIXEREX_ADDONS_URL . 'admin/images/pixerex-addons-logo.png'; ?>">
                </div>
            <?php endif; ?>
        </div>
        <div class="pr-settings-tabs pr-sys-info-tab">
            <div id="pr-system" class="pr-settings-tab">
                <div class="pr-row">                
                    <h3 class="pr-sys-info-title"><?php echo __('System setup information useful for debugging purposes.','pixerex-elementor-elements');?></h3>
                    <div class="pr-system-info-container">
                        <?php
                        require_once ( PIXEREX_ADDONS_PATH . 'admin/includes/dep/info.php');
                        echo nl2br( pr_get_sysinfo() );
                        ?>
                    </div>
                </div>
            </div>
            <?php if( ! Helper_Functions::is_hide_rate() ) : ?>
                <div>
                    <p><?php echo __('Did you like Pixerex Addons for Elementor Plugin? Please ', 'pixerex-elementor-elements'); ?><a href="https://wordpress.org/support/plugin/pixerex-elementor-elements/reviews/#new-post" target="_blank"><?php echo __('Click Here to Rate it ★★★★★', 'pixerex-elementor-elements'); ?></a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php }
}

