<?php

if( ! defined( 'ABSPATH' ) ) exit; //Exit if accessed directly

/**
 *
 *  Fire the rollback function
 * 
*/
function post_pixerex_addons_rollback() {
    
    check_admin_referer( 'pixerex_addons_rollback' );
    
    $plugin_slug = basename( PIXEREX_ADDONS_FILE, '.php' );
    
    $pa_rollback = new PA_Rollback(
        [
            'version' => PIXEREX_ADDONS_STABLE_VERSION,
            'plugin_name' => PIXEREX_ADDONS_BASENAME,
            'plugin_slug' => $plugin_slug,
            'package_url' => sprintf( 'https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, PIXEREX_ADDONS_STABLE_VERSION ),
        ]
    );

    $pa_rollback->run();

    wp_die(
        '', __( 'Rollback to Previous Version', 'pixerex-addons-for-elementor' ), [
        'response' => 200,
        ]
    );
}

