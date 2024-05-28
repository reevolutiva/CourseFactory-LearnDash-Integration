<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/course-deleter.php
 * En este fichero se declara la funcion coursefac_delete_course que sera eliminar un curso de LearnDash
 * con sus respectivos post de la base de datos.
 *
 * @package Course Factory Integration */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Esta funcion se encaragara de eliminar un CPT Curso, con sus respectivos CPT Lession, Topic, Quiz, Question
 * a partir del post_id de CPT Course.
 *
 * @param int $course_id post_id de CPT Course.
 * @return int $result 200 si se elimino correctamente, Exception si hubo algun error.
 */
function coursefac_delete_course( $course_id ) {

	global $wpdb;

	$result = '';

	try {
		// Parseo id.
		$course_id = (int) $course_id;

		// mediante el course_id utilizando la dara jeraquca accederemos el post_id de lesson, topic, quiz.

		// Extraigo de BDD todos los post_id reacionados con el course_id.
		$table_name = $wpdb->prefix . 'postmeta';

		$cpt_id_array = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT post_id 
				FROM {$table_name}
				WHERE meta_key = 'course_id' 
					AND meta_value = %d",
				$course_id
			)
		);

		// Obtenemos los post relacionados con el course_id.
		$cpt_array = array_map(
			function ( $e ) {
				$post_id = $e->post_id;

				$post = get_post( $post_id );

				return $post;
			},
			$cpt_id_array
		);

		// Lista de todos quiz.
		$quiz_array = array_filter(
			$cpt_array,
			fn ( $e ) => 'sfwd-quiz' === $e->post_type
		);

		// Lista de todos topic.
		$topic_array = array_filter(
			$cpt_array,
			fn ( $e ) => 'sfwd-topic' === $e->post_type
		);

		// Lista de todos lesson.
		$lesson_array = array_filter(
			$cpt_array,
			fn ( $e ) => 'sfwd-lessons' === $e->post_type
		);

		// Lista de todos question.
		$question_array = array_map(
			function ( $e ) {

				global $wpdb;

				$table_name = $wpdb->prefix . 'postmeta';

				$quiz_id = $e->ID;

				$question = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT post_id FROM {$table_name} WHERE meta_key = 'quiz_id' AND meta_value = %s",
						$quiz_id
					)
				);

				$res = array(
					'quiz_id'     => $quiz_id,
					'question_id' => $question[0]->post_id,
				);

				return $res;
			},
			$quiz_array
		);

		// Paso 1: Eliminar Questions.

		foreach ( $question_array as $question ) {

			// 1.1 Eliminar Question de la tabla QuizPro.
			$question_id     = $question['question_id'];
			$question_pro_id = (int) get_post_meta( $question_id, 'question_pro_id', true );

			$question_mapper = new \WpProQuiz_Model_QuestionMapper();
			$question_mapper->delete( $question_pro_id );

			// 1.2 Eliminar Question de la tabla wp_postmeta.
			// 1.3 Eliminar Question de la tabla wp_posts.
			wp_delete_post( $question_id, false );
		}

		// Paso 2: Eliminar Quizzes.
		foreach ( $quiz_array as $quiz ) {

			// 2.1 Eliminar Quiz de la tabla QuizPro.
			$quiz_id     = $quiz->ID;
			$quiz_pro_id = (int) get_post_meta( $quiz_id, 'quiz_pro_id', true );

			$quiz_mapper = new \WpProQuiz_Model_QuizMapper();
			$quiz_mapper->delete( $quiz_pro_id );

			// 2.2 Eliminar Quiz de la tabla wp_postmeta.
			// 2.3 Eliminar Quiz de la tabla wp_posts.
			wp_delete_post( $quiz_id, false );
		}

		// Paso 3: Eliminar Topics.
		foreach ( $topic_array as $topic ) {
			$topic_id = $topic->ID;
			wp_delete_post( $topic_id, false );
		}

		// Paso 4: Eliminar Lessons.
		// 4.1 Eliminar Lesson de la tabla wp_postmeta.
		// 4.2 Eliminar Lesson de la tabla wp_posts.
		foreach ( $lesson_array as $lesson ) {
			$lesson_id = $lesson->ID;
			wp_delete_post( $lesson_id, false );
		}

		// Paso 5: Eliminar Course.

		wp_delete_post( $course_id, false );

		$result = 200;
	} catch ( Exception $e ) {
		$result = $e;
	}

	return $result;
}
