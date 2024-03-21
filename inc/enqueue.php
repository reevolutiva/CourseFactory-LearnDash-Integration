<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/enqueue.php
 * Este archivo encola los ficheros de javascript y css necesarios para el funcionamiento del frontend react del plugin de CousreFactory.
 *
 * @package Course Factory Integration. */

declare( strict_types = 1 );

namespace Kucrut\ViteForWPExample\React\Enqueue;

use Kucrut\Vite;

/**
 * Encolado de js y css para el backend.
 *
 * @return void
 */
function frontend(): void {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_script' );
	add_action( 'wp_footer', __NAMESPACE__ . '\\render_app' );
}


/**
 * Encolado de js y css para el backend.
 *
 * @return void
 */
function backend() {
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_script' );
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_css' );
}


/**
 * Render application's markup
 */
function render_app(): void {
	printf( '<div id="my-app" class="my-app"></div>' );
}

/**
 * Enqueue script
 */
function enqueue_script(): void {
	Vite\enqueue_asset(
		dirname( __DIR__ ) . '/js/dist',
		'js/src/main.jsx',
		array(
			'handle'       => 'vite-for-wp-react',
			'in-footer'    => true,
			'dependencies' => array( 'wp-api' ),
		)
	);
}

/**
 * Enqueue CSS
 */
function enqueue_css(): void {
	wp_enqueue_style(
		'admin-styles',
		plugin_dir_url( __FILE__ ) . 'css/custom_admin.css',
		array(),
		'1.0.0',
		'all'
	);
}
