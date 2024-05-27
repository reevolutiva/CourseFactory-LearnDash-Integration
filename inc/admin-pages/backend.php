<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/admin-pages/backend.php.
 *  Este archivo contiene el codigo de la pagina de administracion de coursefactory.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$backend_i18n = cfact_backend_i18n();

wp_localize_script( 'cfact-learndash-integration', 'bakendi18n', $backend_i18n );

// Seccion donde se elimina el APIKEY de course factory.

#TODO: (AIDER/) - "Fix Here".
add_action('admin_init', function() {
    if ( isset( $_GET['delete-api_key'] ) ) {
        #cfact_ld_api_key_mannger( 'delete' );
        wp_redirect( admin_url( 'admin.php?page=course_factory_integration' ) );
        exit;
    }
});
#(/AIDER)

// Seccion de listing.
if ( $api_key && ! isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-listing.php';
}


// Seccion para logearse en course-factory.
if ( ! isset($api_key) || isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-login.php';
}


