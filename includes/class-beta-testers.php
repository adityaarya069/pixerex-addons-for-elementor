<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Pixerex_Beta_Testers {
    
	private $transient_key;
    
    /**
     * Get beta version
     * 
     * Checks if the version in trunk is beta
     * 
     * @since 2.1.3
     * @access public
     */
	private function get_beta_version() {
        
		$beta_version = get_site_transient( $this->transient_key );
        
		if ( false === $beta_version ) {
            
			$beta_version = 'false';

			$response = wp_remote_get( 'https://plugins.svn.wordpress.org/pixerex-elementor-elements/trunk/readme.txt' );
            
			if ( ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {
				preg_match( '/Beta tag: (.*)/i', $response['body'], $matches );
				if ( isset( $matches[1] ) ) {
					$beta_version = $matches[1];
				}
			}

			set_site_transient( $this->transient_key, $beta_version, 6 * HOUR_IN_SECONDS );
            
		}

		return $beta_version;
	}

    /**
     * Get version
     * 
     * Checks if the version in trunk is beta
     * 
     * @since 2.1.3
     * @access public
     */
	public function compare_version( $transient ) {
        
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		delete_site_transient( $this->transient_key );

		$plugin_slug = basename( PIXEREX_ADDONS_FILE , '.php' );

		$beta_version = $this->get_beta_version();
        
		if ( 'false' !== $beta_version && version_compare( $beta_version, PIXEREX_ADDONS_VERSION, '>' ) ) {
            
			$response = new \stdClass();
            
			$response->plugin = $plugin_slug;
            
			$response->slug = $plugin_slug;
            
			$response->new_version = $beta_version;
            
			$response->url = 'https://pixerexaddons.com/';
            
			$response->package = sprintf( 'https://downloads.wordpress.org/plugin/pixerex-elementor-elements.%s.zip', $beta_version );
            
            echo $response->package;
            
			$transient->response[ PIXEREX_ADDONS_BASENAME ] = $response;
		}

		return $transient;
	}
	public function __construct() {
        $check_component_active = isset(get_option( 'pr_beta_save_settings' )['is-beta-tester']) ? get_option( 'pr_beta_save_settings' )['is-beta-tester'] : 1;
		if ( 0 !== $check_component_active ) {
			return;
		}

		$this->transient_key = md5( 'pixerex_addons_beta_response_key' );

		add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'compare_version' ] );
	}
}
