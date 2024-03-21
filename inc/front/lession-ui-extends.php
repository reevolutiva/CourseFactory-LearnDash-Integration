<?php
/**
 * Path: wp-content\plugins\coursefactory-integration\inc\front\lession-ui-extends.php
 *
 * En este fichero se detallan funciones que extienden las funcionalidades de la UI de LearnDash.
 *
 * @package Course Factory Integration.
 */

add_action( 'learndash-lesson-components-before', 'cfact_topic_type_counter', 10, 3 );

/**
 * Lista los topicos dentro de una leccion y cuenta cuantos hay de cada tipo.
 *
 * @param int $lesson_id post_id de lession.
 * @param int $course_id post_id de course.
 * @param int $user_id id del usuario.
 * @return void
 */
function cfact_topic_type_counter( $lesson_id, $course_id, $user_id ) {

	global $wpdb;

	$query = $wpdb->get_results(
		$wpdb->prepare(
			'SELECT post_id FROM `wp_postmeta` WHERE `meta_value` = %s',
			$lesson_id
		)
	);

	$custom_topics = array();

	foreach ( $query as $item ) {
		$post_id    = $item->post_id;
		$cpt        = get_post( $post_id );
		$topic_type = false;

		if ( 'sfwd-topic' === $cpt->post_type ) {
			$topic_type = get_post_meta( $post_id, 'cfact_topic_type', true );
			array_push( $custom_topics, $topic_type );
		}
	}

	// Esta lista es la que ha de ser recorrida.
	$lista = array_count_values( $custom_topics );

	// Recorro la lista.
	foreach ( $lista as $key => $value ) :

		if ( '' === $key ) {
			$key = 'topic';
		}

		$has_underscore = str_contains( $key, '_' ) ? true : false;

		$key_render = $key;

		// Sí Hay solo un topic.
		$singular = 1 === $value ? true : false;

		// Sí el topic NO es sigular añade una "s" al final.
		if ( ! $singular ) {
			$key_render = $key . 's';
		}

		// Si lleva guion bajo.
		if ( $has_underscore ) {

			// Divide $key en base a el caracter ( _ ).
			$key_arr = explode( '_', $key );

			$key_render = $key_arr[0] . ' ' . $key_arr[1];

		}

		?>
		<span class="ld-item-component">
			<?php echo esc_html( $value ); ?>
			<?php echo esc_html( $key_render ); ?>            
		</span>
		<span class="ld-sep">|</span>
		<?php
	endforeach;
}

add_action( 'learndash-topic-row-title-before', 'cfact_topic_type_icon', 10, 3 );

/**
 * Agrega un icono de Course Factory a los topicos.
 *
 * @param int $topic_id post_id de topic.
 * @param int $course_id post_id de course.
 * @param int $user_id id del usuario.
 * @return void
 */
function cfact_topic_type_icon( $topic_id, $course_id, $user_id ) {

	$topic_type = get_post_meta( $topic_id, 'cfact_topic_type', true );
	$icon       = false;

	switch ( $topic_type ) {
		case 'video':
			$icon = 'video.png';
			break;
		case 'reading':
			$icon = 'reading.png';
			break;

		case 'discussion':
			$icon = 'discussion.png';
			break;

		case 'peer_review':
			$icon = 'peer_review.png';
			break;
		case 'activitiy':
			$icon = 'activitiy.png';
			break;

		case 'group_work':
			$icon = 'group.png';
			break;

		case 'survey':
			$icon = 'survey.png';
			break;
		case 'chat':
			$icon = 'chat.png';
			break;
		case 'lecture':
			$icon = 'lecture.png';
			break;

		default:
			// code...
			break;
	}

	if ( false !== $icon ) {

		$url_base = CFACT_PLUGIN_URL . 'inc/img/';

		?>
		<img class="icon-topic-type" src="<?php echo esc_url( $url_base . $icon ); ?>" />
		<?php

	}
}

add_action( 'wp_enqueue_scripts', 'cfact_topic_type_counter_style' );

/**
 * Cargo el css que agrega estilos a los iconos y a los contadores de topicos.
 *
 * @return void
 */
function cfact_topic_type_counter_style() {

	$url_base = CFACT_PLUGIN_URL . 'inc/css/custom.css';

	wp_enqueue_style( 'cfact_custom_style', $url_base );
}


// Este codigo se insertara despues del listing de contenido del curso.
add_action( 'learndash-course-listing-after', 'edit_course_template' );

/**
 * Esta funcion introduce a la UI de LearnDash un script JS que oculta el contador de topicos.
 *
 * @return void
 */
function edit_course_template() {
	?>

	<script>

		const cfact_ld_topic_itemo_for_delete = document.querySelectorAll(".ld-item-list-items .ld-item-name .ld-item-components > span");

		for (let index = 0; index < cfact_ld_topic_itemo_for_delete.length; index++) {

			const element = cfact_ld_topic_itemo_for_delete[index];

			if( element.textContent.includes("Topics") ){
				element.style.display = "none";
				cfact_ld_topic_itemo_for_delete[index - 1].style.display = "none";
			}
			
		}

	</script>

	<?php
}
