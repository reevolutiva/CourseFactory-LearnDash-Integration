<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/i18n/backend-i18n.php
 * Este archivo contiene un array con las traducciones de los textos del backend del plugin CourseFactory Integration.
 *
 * @package Course Factory Integration */

/**
 * Esta funcion retorna un array con las traducciones de los textos del que utlizara la apliacion react que carga en la pagina de administracion del plugin CourseFactory Integration.
 *
 * @return array $backend_i18n Array con las traducciones de los textos del que utlizara la apliacion react que carga en la pagina de administracion del plugin CourseFactory Integration.
 */
function cousefact_backend_i18n() {

	$backend_i18n = array(
		'insert_your_api_key'        => __( 'Insert Your Api Key:', 'coursefactory-integration' ),
		'delete_api_key'             => __( 'Delete Api Key:', 'coursefactory-integration' ),
		'where_to_fin_api:'          => __( 'Where to find my API Key?', 'coursefactory-integration' ),
		'conect_to_course_factory'   => __( 'Connect to CourseFactory AI Copilot', 'coursefactory-integration' ),
		'you_dont_have'              => __( 'You don\'t have an Account?', 'coursefactory-integration' ),
		'open_you_free'              => __( 'Open Your free Account now', 'coursefactory-integration' ),
		'view_course'                => __( 'View course', 'coursefactory-integration' ),
		'import_course'              => __( 'Import course', 'coursefactory-integration' ),
		'course_factory_integration' => __( 'Course Factory Integration', 'coursefactory-integration' ),
		'creating_course'            => __( 'Creating course', 'coursefactory-integration' ),
		'could_lated_a_moment'       => __( 'Could take a moment', 'coursefactory-integration' ),
		'loading'                    => __( 'Loading', 'coursefactory-integration' ),
		'version'                    => __( 'Version', 'coursefactory-integration' ),
		'reimport_course'            => __( 'Reimport course', 'coursefactory-integration' ),
		'delete_from_leardash'       => __( 'Delete from LearnDash', 'coursefactory-integration' ),
		'delelte_course_confirm'     => __( 'This will delete the course and all associated elements in Leandash. Do you want to continue?', 'coursefactory-integration' ),
		'go_to_leardash'             => __( 'Go to LearnDash', 'coursefactory-integration' ),
		'continue'                   => __( 'Continue', 'coursefactory-integration' ),
		'reimport_course_confirm'    => __( 'This will delete your old version of the course in learndash and create a new one. do you wish to continue?', 'coursefactory-integration' ),
		'course_deleted'             => __( 'Course deleted success', 'coursefactory-integration' ),
		'load_courses'               => __( 'Loading courses from CourseFactory Copilot', 'coursefactory-integration' ),
		'error_course_import_reload' => __( 'Oops, an error occurred, the course cannot be deleted, please reload the page and try again. Do you want to reload the page?', 'coursefactory-integration' ),
		'learndash_integration'      => __( 'Learndash integration', 'coursefactory-integration' ),
		'new_project'                => __( 'New Project', 'coursefactory-integration' ),
		'keepme_informed'            => __( 'Keep me  informed about new updates', 'coursefactory-integration' ),
		'do_you_want_redirected'     => __('Do you want to be redirected as a course importer?', 'coursefactory-integration'),
		'you_mail_has_registered'     => __('Your email has been registered to keep you informed about CourseFactory updates.', 'coursefactory-integration')
	);

	return $backend_i18n;
}
