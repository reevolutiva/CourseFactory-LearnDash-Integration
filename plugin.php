<?php
/**
 * Plugin Name: CourseFactory LearnDash Integration #DEV
 * Description: A integration CourseFactory Course creator.
 * Author: Reevolutiva
 * Author URI: https://reevolutiva.cl
 * License: GPLv2
 * Version: 1.0
 * Text Domain: coursefactory-integration
 *
 * @package Course Factory Integration
 */



require 'inc/course-fact-stadistic.php';
require 'inc/front/lession-ui-extends.php';

// Registrar el directorio del plugin.
define( 'CFACT_PLUGIN_DIR', str_replace( '\\', '/', __DIR__ ) );
define( 'CFACT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'CFACT_PLUGIN_VAR_NAME', 'cfact-learndash-integration' );

add_action( 'admin_menu', 'cfact_init_menu' );

/**
 * Init Admin Menu.
 *
 * @return void
 */
function cfact_init_menu() {

	$icon_url = plugin_dir_url( __FILE__ ) . '/js/public/Logo.png';

	add_menu_page(
		__(
			'Course Factory',
			'course_factory_integration'
		),
		__( 'Course Factory', 'course_factory_integration' ),
		'manage_options',
		'course_factory_integration',
		'cfact_admin_page',
		$icon_url,
		'2.1'
	);
}

/**
 * Init Admin Page.
 *
 * @return void
 */
function cfact_admin_page() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/admin-pages/backend.php';
}

/**
 * Obtener la data del cliente.
 *
 * @return array
 */
function cfact_get_client_data() {

		$user = wp_get_current_user();

		$name      = $user->data->user_nicename;
		$last_name = '';

	if ( isset( $user->data->first_name ) ) {
		$name = $user->data->first_name;
	}

	if ( isset( $user->data->last_name ) ) {
		$last_name = $user->data->last_name;
	}

		$args = array(
			'header' => array( 'Accept' => '*/*' ),
			'body'   => array(
				'first_name'    => $name,
				'last_name'     => $last_name,
				'email'         => $user->data->user_email,
				'tag[]'         => '2',
				'list[]'        => '3',
				'status'        => 'subcribed',
				'client_wp_url' => get_bloginfo( 'url' ),
			),
		);

		return $args;
}



// Cuando este plugin se active.
register_activation_hook( __FILE__, 'cfact_activation' );

/**
 * Cuando este plugin se active.
 *
 * @return void
 */
function cfact_activation() {

	// Verfica si learnDash esta instalado.

	$plugins_active = get_option( 'active_plugins' );

	if ( ! in_array( 'sfwd-lms/sfwd_lms.php', $plugins_active ) ) {
		wp_die( 'LearnDash is not installed', 'LearnDash is not installed', array( 'back_link' => true ) );
	}

	global $wpdb;

	// obtener learndash_settings_lessons_cpt de wp_options.
	$learndash_settings_lessons_cpt = get_option( 'learndash_settings_topics_cpt' );

	$supports = $learndash_settings_lessons_cpt['supports'];

	// en el array $supports, existe el string "comments", si no existe, entonces añadelo.
	if ( ! in_array( 'comments', $supports ) ) {
		array_push( $supports, 'comments' );

		$nuevo             = $learndash_settings_lessons_cpt;
		$nuevo['supports'] = $supports;
		$wpdb->query( $wpdb->prepare( 'UPDATE wp_options SET option_value = %s WHERE option_name = %s', serialize( $nuevo ), 'learndash_settings_topics_cpt' ) );
	}

	// Enviar weebhook a CourseFactory para que sepa que este plugin esta instalado.
	cfact_integration_send_stadistic( 'activation' );
}

// Cuando este plugin se desactive.
register_deactivation_hook( __FILE__, 'cfact_deactivation' );

/**
 * Esta funcion se ejecuta cuando este plugin se desactive.
 *
 * @return void
 */
function cfact_deactivation() {
	// Enviar weebhook a CourseFactory para que sepa que este plugin esta instalado.
	cfact_integration_send_stadistic( 'diactivation' );
}



require 'i18n/backend-i18n.php';

require 'inc/course-importer.php';

require 'inc/class/class-cfact-ld-section-heading.php';

require 'inc/corusefactory-request.php';

require 'inc/api-key-mannager.php';

require 'inc/endpoints.php';

require 'inc/custom-fields.php';

require 'inc/shortcode.php';

require 'inc/course-deleter.php';

require 'vite-load.php';
