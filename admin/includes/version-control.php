<?php

namespace PixerexAddons\Admin\Includes;

use PixerexAddons\Helper_Functions;

if( ! defined( 'ABSPATH' ) ) exit;

class Version_Control {
    
    public $pr_beta_keys = [ 'is-beta-tester' ];
    
    private $pr_beta_default_settings;
    
    private $pr_beta_settings;
    
    private $pr_beta_get_settings;
    
    public function __construct() {
        
       // add_action( 'admin_menu', array ($this,'create_version_control_menu' ), 100 );
        
        add_action( 'wp_ajax_pr_beta_save_settings', array( $this, 'pr_beta_save_settings' ) );
        
    }
    
    
    public function create_version_control_menu() {
        
        if ( ! Helper_Functions::is_hide_version_control() ) {
            
                add_submenu_page(
                'pixerex-addons',
                '',
                __('Version Control','pixerex-elementor-elements'),
                'manage_options',
                'pixerex-addons-version',
                [$this, 'pr_version_page']
            );
        }
        
    }
    
    public function pr_version_page() {
        
        $js_info = array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'nonce' 	=> wp_create_nonce( 'pr-version-control' ),
	);
        
        wp_localize_script( 'pr-admin-js', 'settings', $js_info );
        
        $this->pr_beta_default_settings = array_fill_keys( $this->pr_beta_keys, true );
       
        $this->pr_beta_get_settings = get_option( 'pr_beta_save_settings', $this->pr_beta_default_settings );
        
        $pr_beta_new_settings = array_diff_key( $this->pr_beta_default_settings, $this->pr_beta_get_settings );
        
        if( ! empty( $pr_beta_new_settings ) ) {
            $pr_beta_updated_settings = array_merge( $this->pr_beta_get_settings, $pr_beta_new_settings );
            update_option( 'pr_beta_save_settings', $pr_beta_updated_settings );
        }
        
        $this->pr_beta_get_settings = get_option( 'pr_beta_save_settings', $this->pr_beta_default_settings );
        
    ?>
      
    <div class="wrap">
        <div class="response-wrap"></div>
        <form action="" method="POST" id="pr-beta-form" name="pr-beta-form">
       <div class="pr-header-wrapper">
          <div class="pr-title-left">
             <h1 class="pr-title-main"><?php echo Helper_Functions::name(); ?></h1>
             <h3 class="pr-title-sub"><?php echo sprintf(__('Thank you for using %s. This plugin has been developed by %s and we hope you enjoy using it.','pixerex-elementor-elements'), Helper_Functions::name(), Helper_Functions::author() ); ?></h3>
          </div>
          <?php if( ! Helper_Functions::is_hide_logo() ) : ?>
                <div class="pr-title-right">
                    <img class="pr-logo" src="<?php echo PIXEREX_ADDONS_URL . 'admin/images/pixerex-addons-logo.png'; ?>">
                </div>
            <?php endif; ?>
       </div> 
      <div class="pr-settings-tabs">
          <div id="pr-maintenance" class="pr-settings-tab">
             <div class="pr-row">
                <table class="pr-beta-table">
                   <tr>
                      <th>
                         <h4 class="pr-roll-back"><?php echo __('Rollback to Previous Version', 'pixerex-elementor-elements'); ?></h4>
                         <span class="pr-roll-back-span"><?php echo sprintf( __('Experiencing an issue with pixerex Addons for Elementor version %s? Rollback to a previous version before the issue appeared.', 'pixerex-elementor-elements'), PIXEREX_ADDONS_VERSION ); ?></span>
                      </th>
                   </tr>
                   <tr class="pr-roll-row">
                      <th><?php echo __('Rollback Version', 'pixerex-elementor-elements'); ?></th>
                      <td>
                         <div><?php echo  sprintf( '<a target="_blank" href="%1$s" class="button pr-btn pr-rollback-button elementor-button-spinner">%2$s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=pixerex_addons_rollback' ), 'pixerex_addons_rollback' ), __('Rollback to Version ' . PIXEREX_ADDONS_STABLE_VERSION, 'pixerex-elementor-elements') ); ?></div>
                         <p class="pr-roll-desc">
                             <span><?php echo __('Warning: Please backup your database before making the rollback.', 'pixerex-elementor-elements'); ?></span>
                         </p>
                      </td>
                   </tr>
                   <tr>
                      <th>
                         <h4 class="pr-beta-test"><?php echo __('Become a Beta Tester', 'pixerex-elementor-elements'); ?></h4>
                         <span class="pr-beta-test-span"><?php echo __('Turn-on Beta Tester, to get notified when a new beta version of pixerex Addons for Elementor. The Beta version will not install automatically. You always have the option to ignore it.', 'pixerex-elementor-elements'); ?></span>
                      </th>
                   </tr>
                   <tr class="pr-beta-row">
                      <th><?php echo __('Beta Tester','pixerex-elementor-elements'); ?></th>
                      <td>
                         <div><input name="is-beta-tester" id="is-beta-tester" type="checkbox" <?php checked(1, $this->pr_beta_get_settings['is-beta-tester'], true) ?>><span><?php echo __('Check this box to get updates for beta versions','pixerex-elementor-elements'); ?></span></div>
                         <p class="pr-beta-desc"><span><?php echo __('Please Note: We do not recommend updating to a beta version on production sites.', 'pixerex-elementor-elements'); ?></span></p>
                      </td>
                   </tr>
                </table>
                <input type="submit" value="<?php echo __('Save Settings', 'pixerex-elementor-elements'); ?>" class="button pr-btn pr-save-button">
             </div>
          </div>
       </div>
        </form>
    </div>

    <?php }
    
    public function pr_beta_save_settings() {
        
        check_ajax_referer('pr-version-control', 'security');

        if( isset( $_POST['fields'] ) ) {
            parse_str( $_POST['fields'], $settings );
        } else {
            return;
        }
        
        $this->pr_beta_settings = array(
            'is-beta-tester'            => intval( $settings['is-beta-tester'] ? 1 : 0 ),
        );
        
        update_option( 'pr_beta_save_settings', $this->pr_beta_settings );
        
        return true;
    }
}