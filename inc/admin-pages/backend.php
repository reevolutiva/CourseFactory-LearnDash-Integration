<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/admin-pages/backend.php.
 *  Este archivo contiene el codigo de la pagina de administracion de coursefactory.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_script( 'cfact-backend-script', plugins_url( 'coursefactory-integration/js/backend.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
wp_localize_script( 'cfact-backend-script', 'cfact_backend_i18n', $backend_i18n );

// Seccion donde se elimina el APIKEY de course factory.
if ( isset( $_GET['delete-api_key'] ) ) {
	cfact_ld_api_key_mannger( 'delete' );
	wp_redirect( admin_url( 'admin.php?page=course_factory_integration' ) );
	exit;

	#TODO: (AIDER/)

}

// Seccion de listing.
if ( $api_key && ! isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-listing.php';
}
