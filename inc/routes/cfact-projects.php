<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/routes/cfact-projects.php
 * En este archivo se registran las rutas para interactuar con la api de CourseFactory mediante la api de WordPress.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Regitro la ruta cfact-get-project para obtener la lista de proyectos desde CourseFactory.
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'cfact/v1',
			'cfact-get-project',
			array(
				'methods'             => 'GET',
				'callback'            => 'cfact_get_projects_callback',
				'permission_callback' => function () {
					return current_user_can( 'delete_posts' );
				},
			)
		);
	}
);

/**
 * Esta funcion es el callback de el endpoint cfact/v1/cfact-get-project obtiene un proyecto de CourseFactory mediante su id.
 *
 * @param WP_REST_Request $request Objeto de la peticion.
 * @return array
 */
function cfact_get_projects_callback( $request ) {

	$project_import_id = $request->get_param( 'project_import_id' );

	$api_key = cfact_ld_api_key_mannger( 'get' );

	// Listamos todas las verciones de ese proyecto.
	$versions = cfac_get_proyect_versions( $api_key, $project_import_id );
	$versions = json_decode( $versions );

	$default_version_id = '';

	foreach ( $versions->data as $version ) {
		if ( $version->is_active ) {
			$default_version_id = $version->id;
			break;
		}
	}

	$proyecto = cfac_get_proyect_version( $api_key, $project_import_id, $default_version_id );
	$proyecto = json_decode( $proyecto );

	return $proyecto;
}


// Aqui se registra la ruta para obtener la lista de proyect list desde Coursefactory.

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'cfact/v1',
			'cfact-projects-import',
			array(
				'methods'             => 'POST',
				'callback'            => 'cfact_projects_import_callback',
				'permission_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
);

/**
 * Esta funcion es el callback de el endpoint cfact/v1/cfact-projects-import, importa un proyecto de CourseFactory a LearnDash.
 *
 * @param [type] $request Objeto de la peticion.
 * @return array
 */
function cfact_projects_import_callback( $request ) {

	$status    = 'ok';
	$course_id = false;
	$reimport  = $request->get_param( 'reimport' );

	try {

		if ( 'false' !== $reimport ) {

			$course_id = (int) $reimport;

			coursefac_delete_course( $course_id );
		}

		$api_key = cfact_ld_api_key_mannger( 'get' );

		$project_import_id = $request->get_param( 'project_import_id' );

		// Listamos todos los proyectos.
		$req_proyects = cfac_get_list_proyects( $api_key );
		$req_proyects = json_decode( $req_proyects );

		$proyect_meta = false;

		$proyectos = array();
		if ( isset( $req_proyects->data ) ) {
			$proyectos = $req_proyects->data;
		}

		// Calculamos cuantas veces debe iterar para hacer fetch de todo.
		$proyectos = cfact_get_all_content_by_pagination( $req_proyects, $proyectos, $api_key );

		// error_log( print_r( $proyect_meta, true ) );

		// Obtenemos el id de cada proyecto y mediante ese ID Listamos todas las verciones de ese proyecto.

		if ( $req_proyects->data ) {

			$project_import_id = (int) $project_import_id;

			error_log( print_r( 'project_import_id', true ) );
			error_log( print_r( $project_import_id, true ) );

			error_log( print_r( 'n proyectos', true ) );
			error_log( print_r( COUNT( $proyectos ), true ) );

			foreach ( $proyectos as $proyect_item ) {

				if ( $proyect_item->id === $project_import_id ) {

					error_log( print_r( 'Aqui lo consigo', true ) );

					$proyect_meta = $proyect_item;
					break;
				}
			}
		}

		// Listamos todas las verciones de ese proyecto.
		$versions = cfac_get_proyect_versions( $api_key, $project_import_id );
		$versions = json_decode( $versions );

		$default_version_id = '';

		foreach ( $versions->data as $version ) {
			if ( $version->is_active ) {
				$default_version_id = $version->id;
				break;
			}
		}

		$proyecto = cfac_get_proyect_version( $api_key, $project_import_id, $default_version_id );
		$proyecto = json_decode( $proyecto );

		error_log( print_r( 'proyect_meta', true ) );
		error_log( print_r( $proyect_meta, true ) );
		$course_id = cfact_ld_course_importer( $proyecto, $proyect_meta );

		if ( is_array( $course_id ) ) {
			$course_id = $course_id[1];
			$status    = 'error';
		}

		cfact_integration_send_stadistic( 'imported' );
		update_option( 'cfact-status-imported', 'free' );

	} catch ( Exception $e ) {
		$status = 'error';
	}

	return array(
		'status'    => $status,
		'course_id' => $course_id,
	);
}




// Aquí registro la ruta para obtener el contenido de una sección de un curso.
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'cfact/v1',
			'cfact-content',
			array(
				'methods'             => 'GET',
				'callback'            => 'cfact_curso_content_callback',
				'permission_callback' => function () {
					return current_user_can( 'read' );
				},
			)
		);
	}
);

/**
 * Esta funcion es el callback de el endpoint cfact/v1/cfact-content, obtiene el contenido de una sección de un curso.
 *
 * @param [type] $request Objeto de la peticion.
 * @return string | null
 */
function cfact_curso_content_callback( $request ) {

	$api_key = cfact_ld_api_key_mannger( 'get' );
	$content = false;

	// Obtengo las variables enviadas por GET en la peticion.
	$content_version_id = $request->get_param( 'content_version_id' );
	$topic_id           = $request->get_param( 'topic_id' );

	// Si existe el parametro $content_version_id, obtengo el contenido de ese topic.
	if ( null !== $content_version_id && '' !== $topic_id ) {

		$req = cfac_get_content_version( $api_key, $content_version_id );
		$req = json_decode( $req );

		$topic_type = $req->type;

		// Si topic es de tipo "reading", obtengo el contenido de ese topic.

		if ( 'reading' === $topic_type ) {

			$data = $req->data;

			$content_list = $data->content_list;

			$content = '';

			foreach ( $content_list as $content_item ) {

				if ( 'paragraph' === $content_item->content_type ) {
					$content .= '<p>' . $content_item->content->text . '</p>';
				}
			}

			// Actulizar el cpt swd_topic con el post_content $content.

			$res =
				wp_update_post(
					array(
						'ID'           => $topic_id,
						'post_content' => $content,
					)
				);
		}

		// Si topic es de tipo "video", obtengo el contenido de ese topic.

		if ( 'video' === $topic_type ) {

			// Obtengo el Guion del video.

			$data = $req->data;

			$title = $data->title;

			$description = $data->description;

			$script = $data->script;

			$content = "<p>$description</p>";

			foreach ( $script as $content_item ) {

				if ( 'paragraph' === $content_item->content_type ) {
					$content .= '<p>' . $content_item->content->text . '</p>';
				}
			}

			$post_arr = array(
				'ID'           => $topic_id,
				'post_title'   => $title,
				'post_content' => $content,
			);

			$res = wp_update_post( $post_arr );

			// Script es un array de objetos, cada objeto tiene un atributo "content" que a su vez contiene un atributo "text" que contiene el texto del guion.

		}

		// Si topic es de tipo "peer_review", obtengo el contenido de ese topic.

		return $req;
	} else {
		return 'No se ha enviado el parametro content_version_id o topic_id';
	}
}
