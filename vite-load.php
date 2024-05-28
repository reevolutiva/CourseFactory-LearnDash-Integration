<?php
/**
 * Path: app\public\wp-content\plugins\coursefactory-integration\vite-load.php
 * este archivo encola composer e /inc/enqueue.php
 *
 * @package Course Factory Integration */

// namespace Kucrut\ViteForWPExample\React;

// require_once __DIR__ . '/vite-for-wp.php';
// require_once __DIR__ . '/inc/Enqueue.php';

// Enqueue\frontend();
// Enqueue\backend();


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

function enqueue_script(){

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
        '1.0.0',
        true
    );

    wp_enqueue_script('cfact-learndash-integration');
    wp_enqueue_script('cfact-learndash-integration-customize');

    wp_scripts()->add_data('cfact-learndash-integration', 'type', 'module');

}

add_action( 'wp_enqueue_scripts', 'enqueue_script' );
add_action( 'admin_enqueue_scripts', 'enqueue_script' );
add_action( 'admin_enqueue_scripts', 'enqueue_css' );

add_filter('script_loader_tag', 'moduleTypeScripts', 10, 2);

function moduleTypeScripts($tag, $handle)
{
    $tyype = wp_scripts()->get_data($handle, 'type');

    if ($tyype) {
        $tag = str_replace('src', 'type="' . esc_attr($tyype) . '" src', $tag);
    }

    return $tag;
}