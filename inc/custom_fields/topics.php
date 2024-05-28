<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/custom_fields/topics.php
 * Este archivo contiene el codigo para añadir los campos personalizados a los temas de LearnDash.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Esta funcion registra el campo personalizado cfact_topic_type para los temas de LearnDash.
 *
 * @return void
 */
function cfact_register_topic_type_field() {
	register_post_meta(
		'sfwd-topic',
		'cfact_topic_type',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);
}

/**
 * Esta funcion añade el metabox para el campo personalizado cfact_topic_type para los temas de LearnDash.
 *
 * @return void
 */
function cfact_add_topic_type_metabox() {
	add_meta_box(
		'cfact_topic_type_metabox',
		'CFact Topic Type',
		'render_cfact_topic_type_metabox',
		'sfwd-topic',
		'normal',
		'default'
	);
}

/**
 * Esta funcion renderiza el metabox para el campo personalizado cfact_topic_type para los temas de LearnDash.
 *
 * @param [type] $post El post actual.
 * @return void
 */
function render_cfact_topic_type_metabox( $post ) {

	$value = get_post_meta( $post->ID, 'cfact_topic_type', true );

	// Agregar el campo nonce.
	wp_nonce_field( 'cfact_save_topic_type_metabox', 'cfact_topic_type_nonce' );
	?>
	<label for="cfact_topic_type"> <?php echo esc_html( __( 'CFact Topic Type', 'coursefactory-integration' ) ); ?> :</label>
	<select id="cfact_topic_type" name="cfact_topic_type">
		<option value="quiz" <?php selected( $value, 'quiz' ); ?>><?php echo esc_html( __( 'Quiz', 'coursefactory-integration' ) ); ?></option>
		<option value="video" <?php selected( $value, 'video' ); ?>><?php echo esc_html( __( 'Video', 'coursefactory-integration' ) ); ?></option>
		<option value="reading" <?php selected( $value, 'reading' ); ?>><?php echo esc_html( __( 'Reading', 'coursefactory-integration' ) ); ?></option>
		<option value="peer_review" <?php selected( $value, 'peer_review' ); ?>><?php echo esc_html( __( 'Peer Review', 'coursefactory-integration' ) ); ?></option>
		<option value="discussion" <?php selected( $value, 'discussion' ); ?>><?php echo esc_html( __( 'Discussion', 'coursefactory-integration' ) ); ?></option>
		<option value="group_work" <?php selected( $value, 'group_work' ); ?>><?php echo esc_html( __( 'Group Work', 'coursefactory-integration' ) ); ?></option>
		<option value="lecture" <?php selected( $value, 'lecture' ); ?>><?php echo esc_html( __( 'Lecture', 'coursefactory-integration' ) ); ?></option>
		<option value="chat" <?php selected( $value, 'chat' ); ?>><?php echo esc_html( __( 'Chat', 'coursefactory-integration' ) ); ?></option>
		<option value="survey" <?php selected( $value, 'survey' ); ?>><?php echo esc_html( __( 'Survey', 'coursefactory-integration' ) ); ?></option>
		<option value="assignment" <?php selected( $value, 'assignment' ); ?>><?php echo esc_html( __( 'Assignment', 'coursefactory-integration' ) ); ?></option>
	</select>
	<?php
}

/**
 * Esta funcion procesa el campo personalizado cfact_topic_type para los temas de LearnDash.
 *
 * @param int $post_id El id del post actual.
 * @return void
 */
function cfact_save_topic_type_metabox( $post_id ) {
	// Verificar si el nonce está presente.
	if ( ! isset( $_POST['cfact_topic_type_nonce'] ) ) {
		return;
	}

	// Verificar si el nonce es válido.
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cfact_topic_type_nonce'] ) ), 'cfact_save_topic_type_metabox' ) ) {
		return;
	}

	// Verificar si el usuario actual tiene permiso para editar el post.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Verificar si el valor está presente.
	if ( isset( $_POST['cfact_topic_type'] ) ) {
		$cfact_topic_type = sanitize_text_field( wp_unslash( $_POST['cfact_topic_type'] ) );
		update_post_meta( $post_id, 'cfact_topic_type', $cfact_topic_type );
	}
}

add_action( 'init', 'cfact_register_topic_type_field' );
add_action( 'add_meta_boxes', 'cfact_add_topic_type_metabox' );
add_action( 'save_post_sfwd-topic', 'cfact_save_topic_type_metabox' );



