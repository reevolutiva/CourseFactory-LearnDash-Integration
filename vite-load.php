<?php
/**
 * Path: app\public\wp-content\plugins\coursefactory-integration\vite-load.php
 * este archivo encola composer e /inc/enqueue.php
 *
 * @package Course Factory Integration */

/**
 * Enqueue CSS
 */
function enqueue_css(): void {

	wp_enqueue_style(
		'custom-styles',
		CFACT_PLUGIN_URL . 'inc/css/custom_admin.css',
		array(),
		'1.0.0',
		'all'
	);

	wp_enqueue_style(
		'admin-styles',
		CFACT_PLUGIN_URL . 'js/dist/assets/main-0e42df32.css',
		array(),
		'1.0.0',
		'all'
	);
}

/**
 * Enqueues the necessary JavaScript files.
 *
 * @return void
 */
function enqueue_script() {

	wp_register_script(
		'cfact-learndash-integration',
		CFACT_PLUGIN_URL . 'js/dist/assets/main-a8d868b3.js',
		array( 'wp-api' ),
		'1.0.0',
		true
	);

	wp_register_script(
		'cfact-learndash-integration-customize',
		CFACT_PLUGIN_URL . 'js/public/cfactory-customize.js',
		array(),
		'1.0.0',
		true
	);

	wp_enqueue_script( 'cfact-learndash-integration' );
	wp_enqueue_script( 'cfact-learndash-integration-customize' );

	wp_scripts()->add_data( 'cfact-learndash-integration', 'type', 'module' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_script' );
add_action( 'admin_enqueue_scripts', 'enqueue_script' );
add_action( 'admin_enqueue_scripts', 'enqueue_css' );

add_filter( 'script_loader_tag', 'module_type_scripts', 10, 2 );

/**
 * Adds the type attribute to script tags.
 *
 * @param string $tag    The HTML script tag.
 * @param string $handle The script handle.
 *
 * @return string The modified HTML script tag.
 */
function module_type_scripts( $tag, $handle ) {
	$type = wp_scripts()->get_data( $handle, 'type' );

	if ( $type ) {
		$tag = str_replace( 'src', 'type="' . esc_attr( $type ) . '" src', $tag );
	}

	return $tag;
}
