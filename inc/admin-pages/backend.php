<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/backend.php.
 *  Este archivo contiene el codigo de la pagina de admistracion de coursefactory.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

wp_enqueue_script( 'cfact-backend-script', plugins_url( 'coursefactory-integration/js/backend.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
wp_localize_script( 'cfact-backend-script', 'cfact_backend_i18n', $backend_i18n );

// Seccion donde se elimina el APIKEY de course factory.
if ( isset( $_GET['delete-api_key'] ) ) {

	cfact_ld_api_key_mannger( 'delete' );
	?>
	
	#TODO: (AIDER/) redirecciona la url que defino en la linea de abajo usando la funcion wp_redirect.
	
	<script>
		location.href = `${location.origin}/wp-admin/admin.php?page=course_factory_integration`;
	</script>
	<?php
	die();
	
	#(/AIDER)

}

// Seccion de listing.
if ( $api_key && ! isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-listing.php';
}

// Seccion para logearse en course-factory.
if ( ! $api_key || isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-login.login.php';
}

