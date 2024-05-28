<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/admin-pages/backend.php.
 *  Este archivo contiene el codigo de la pagina de administracion de coursefactory.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$api_key = cfact_ld_api_key_mannger( 'get' );

$backend_i18n = cfact_backend_i18n();

/**
 * Retrieve an array of blog information.
 *
 * @return array An associative array of blog information.
 */
function bloginfo_array() {
	$fields = array( 'name', 'description', 'url', 'admin_email', 'language' );
	$data   = array();
	foreach ( $fields as $field ) {
		$data[ $field ] = get_bloginfo( $field );
	}
	return $data;
}



wp_add_inline_script( 'cfact-learndash-integration', 'var bakendi18n =' . wp_json_encode( $backend_i18n ) . ';', 'before' );
wp_add_inline_script( 'cfact-learndash-integration', 'var req_project_list = false;', 'before' );
wp_add_inline_script( 'cfact-learndash-integration', 'var cfact_blog_info =' . wp_json_encode( bloginfo_array() ) . ';', 'before' );
wp_add_inline_script( 'cfact-learndash-integration', 'var cfact_current_user =' . wp_json_encode( wp_get_current_user() ) . ';', 'before' );
wp_add_inline_script( 'cfact-learndash-integration', 'var CFACT_PLUGIN_URL_COURSE_LOG="' . plugins_url( 'coursefactory-integration/course-log.json' ) . '";', 'before' );
if ( false === $api_key ) {
	wp_add_inline_script( 'cfact-learndash-integration', 'var cfact_learndash_integration_apiKey = "";', 'before' );
} else {
	wp_add_inline_script( 'cfact-learndash-integration', 'var cfact_learndash_integration_apiKey ="' . $api_key . '";', 'before' );
}


if ( isset( $_GET['cfact_view_config'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['cfact_view_config'] ) ), 'cfact_view_config_nonce' ) ) {
	return;
}

// Seccion de listing.
if ( $api_key && ! isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-listing.php';
}


// if ( isset( $_GET['cfact_view_config'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['cfact_view_config'] ) ), 'cfact_view_config_nonce' ) ) {
// return;
// }

// Seccion para logearse en course-factory.
if ( ! $api_key || isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-login.php';
}
