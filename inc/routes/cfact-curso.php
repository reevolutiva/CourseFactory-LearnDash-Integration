<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/routes/cfact-curso.php
 * Aqui se registra la ruta para añadir metadata de Coursefactory a un Curso previamente importado desde CoruseFactory a LearnDash.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'rest_api_init',
	function () {

		// Esta ruta de la API de WordPress se utiliza para eliminar un curso de CourseFactory en LearnDash.

		register_rest_route(
			'cfact/v1',
			'cfact-curso-delete',
			array(
				'methods'             => 'DELETE',
				'callback'            => 'cfact_curso_delete_callback',
				'permission_callback' => function () {
					return current_user_can( 'read' );
				},
			)
		);

		// Esta ruta de la API de WordPress se utiliza para añadir añadir la secciones de un curso de LearnDash.

		register_rest_route(
			'cfact/v1',
			'cfact-course-section',
			array(
				'methods'             => 'POST',
				'callback'            => 'cfact_curso_section_callback',
				'permission_callback' => function () {
					return current_user_can( 'read' );
				},
			)
		);
	}
);

/**
 * Esta funcion es el callback de la ruta cfact-curso-delete y
 * se utiliza para eliminar un curso de CourseFactory en LearnDash.
 *
 * @param WP_REST_Request $request Un objeto con la informacion del request.
 * @return int
 */
function cfact_curso_delete_callback( $request ) {

	$body      = $request->get_body();
	$body      = json_decode( $body, true );
	$course_id = $body['course_id'];

	$res = coursefac_delete_course( $course_id );

	return $res;
}

/**
 * Esta funcion es el callback para la ruta cfact-course-section  y
 * se utiliza para añadir las secciones de un curso de LearnDash.
 *
 * @param WP_REST_Request $request Un objeto con la informacion del request.
 * @return array
 */
function cfact_curso_section_callback( $request ) {

	// Obtengo el body del request.
	$body = $request->get_body();

	// Lo decodifico.
	$body = json_decode( $body, true );

	// Verificar si las llaves existen.
	if ( array_key_exists( 'course-section', $body ) && array_key_exists( 'course_id', $body ) ) {
		// Obtengo los datos del key "course-section".
		$course_section = $body['course-section'];

		// Obtengo el id del curso.
		$course_id = (int) $body['course_id'];

		update_post_meta( $course_id, 'course_sections', wp_json_encode( $course_section, JSON_UNESCAPED_UNICODE ) );

	}

	return $body;
}
