<?php
/**
 * Path: wp-content/plugins/coursefac-integration/inc/course-loger.php
 *
 * Este fichero contiene la funcion que gestioana la creacion del JSON que hace el LOG
 * del progreso de la importacion del curso.
 *
 * @package Course Factory Itegration */

/**
 * Esta funcion escribe un JSON que representa el esta actual de la importacion de un curso.
 * en la ruta configurada en la constante CFACT_PLUGIN_PATH_COURSE_LOG.
 *
 * @param mixed $model Array que contiene toda informacion del curso.
 * @return void
 */
function cfact_course_import_json_logger_write_json( $model ) {

	// Codifico a JSON.
	$json_datos = json_encode( $model, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES );

	// Escribo el fichero JSON en la ubicacion en CFACT_PLUGIN_PATH_COURSE_LOG.
	file_put_contents( CFACT_PLUGIN_PATH_COURSE_LOG, $json_datos );
}

/**
 * Esta funcion actualiza un JSON que representa el esta actual de la importacion de un curso.
 *
 * @param mixed  $data objeto el curso a importar.
 * @param string $action string que detemin si la operaion es de actualizacion o creacion.
 * @param string $target que define si vamos a afectar un curso, leccion o topic.
 * @param int    $section_index posicion de la seccion a editar.
 * @param int    $lession_index posicion de la leccion a editar.
 * @param int    $topic_index posicion de la topic a editar.
 * @return void
 */
function cfact_course_import_json_logger( $data, $action, $target = false, $section_index = false, $lession_index = false, $topic_index = false ) {

	error_log( "Se ejecuto un vez para $action" );

	// Creamos el fichero.
	if ( 'create' === $action ) {

		$model = $data;

		// Imported de course.
		$model->imported = false;

		// Guardamos una lista con un objeto que representa un secion del curso.
		$structure_list = $model->structure_list;

		// Recorremos una lista con un objetos que representa un secion del curso.
		foreach ( $structure_list as $key => $section ) {

			// Guardamos una lista de objetos que reperesentan las lecciones del curso.
			$sub_content_list = $section->sub_structure_list;

			// Recorremos una lista de objetos que reperesentan las lecciones del curso.
			foreach ( $sub_content_list as $lesson ) {

				// Imported de lesson.
				$lesson->imported = false;

				// Guardamos una lista con un objetos que representa un topicos del curso.
				$sub_structure_list = $lesson->sub_structure_list;

				// Recorremos una lista con un objetos que representa un topicos del curso.
				foreach ( $sub_structure_list as $topic ) {
					// Imported de topic.
					$topic->imported = false;
				}
			}
		}

		cfact_course_import_json_logger_write_json( $model );
	}

	// Modificamos el fichero.
	if ( 'edit' === $action ) {

		$file = file_get_contents( CFACT_PLUGIN_PATH_COURSE_LOG );
		$json = json_decode( $file, true );

		// Clonamos el contenido del JSON.
		$model = $json;

		switch ( $target ) {

			case 'course':
				// Imported de course.
				$model['imported'] = true;

				cfact_course_import_json_logger_write_json( $model );

				break;

			case 'lession':
				$lession_list = array();

				// Guardamos una lista con objetos que representan una seccion del curso.
				$structure_list = $model['structure_list'];

				// Recorremos una lista con objetos que representan una seccion del curso.
				foreach ( $structure_list as $key => $section ) {

					// Guardamos una lista de objetos que reprensentan una leccion.
					$sub_content_list = $section['sub_structure_list'];

					// Recorremos lista de objetos que reprensentan una leccion.
					foreach ( $sub_content_list as $key => $lesson ) {

						// Si el elemento en la lista tiene el mismo indice declarado en $lession_index entonces cambia el estado.
						if ( $key === $lession_index ) {

							// Imported de lesson.
							$lesson['imported'] = true;

							array_push( $lession_list, $lesson );
						} else {
							array_push( $lession_list, $lesson );
						}
					}
				}

				$model['structure_list'][ $section_index ]['sub_structure_list'] = $lession_list;

				cfact_course_import_json_logger_write_json( $model );

				break;
			case 'topic':
				$new_topic      = '';
				$structure_list = $model['structure_list'];

				// Recorremos la estructura del curso.
				foreach ( $structure_list as $key => $value ) {

					// Encabezado de seccion.
					$sub_content_list = $value['sub_structure_list'];

					// Recorremos lista de lecciones.
					foreach ( $sub_content_list as $key => $lesson ) {

						$sub_structure_list = $lesson['sub_structure_list'];

						if ( $lession_index === $key ) {

							// Recorremos la lista de topics.
							foreach ( $sub_structure_list as $k => $topic ) {

								// Si el elemento en la lista tiene el mismo indice declarado en $lession_index entonces cambia el estado.
								if ( $k === $topic_index ) {

									// Imported de topic.
									$topic['imported'] = true;

									$new_topic = $topic;
								}
							}
						}
					}
				}

				$model['structure_list'][ $section_index ]['sub_structure_list'][ $lession_index ]['sub_structure_list'][ $topic_index ] = $new_topic;

				cfact_course_import_json_logger_write_json( $model );

				break;

			default:
				// code...
				break;
		}
	}

	if ( 'delete' === $action ) {
		file_put_contents( CFACT_PLUGIN_PATH_COURSE_LOG, '[]' );
	}
}
