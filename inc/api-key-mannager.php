<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/api-key-mannager.php
 *
 * @package Course Factory Integration */

if ( ! defined( 'ABSPATH' ) ) exit; 

/**
 * Esta función se encarga de gestionar la API KEY de Coursefactory.
 * Si el parámetro $action es "add" o "update" se añade o actualiza el valor del meta_key cfact_ld_api_key.
 * Si el parámetro $action es "delete" se elimina el valor del meta_key cfact_ld_api_key.
 *
 * @param string $action Si el parámetro $action es "add" o "update" se añade o actualiza el valor del meta_key cfact_ld_api_key si es "delete" se elimina el valor del meta_key cfact_ld_api_key.
 * @param mixed  $data  Valor que se añadira o actualizara en el meta_key cfact_ld_api_key.
 * @return mixed
 */
function cfact_ld_api_key_mannger( $action, $data = null ) {
	// Obtener el valor actual del meta_key cfact_ld_api_key.

	$current_value = get_option( 'cfact_ld_api_key' );

	if ( 'add' === $action || 'update' === $action ) {

		try {
				// Comprobar si el valor existe.
			if ( $current_value ) {
				// Actualizar el valor existente.
				update_option( 'cfact_ld_api_key', $data );
			} else {
				// Crear un nuevo valor.
				add_option( 'cfact_ld_api_key', $data );
			}
		} catch ( Exception $e ) {

			wp_die( esc_html( $e->getMessage() ) );

		}

			// Obtener el valor actualizado.
			$updated_value = get_option( 'cfact_ld_api_key' );

			return $updated_value;

	}

	if ( 'delete' === $action ) {

		// Eliminar el valor.
		$deleted = delete_option( 'cfact_ld_api_key' );

		// Devolver el valor actualizado.
		return $deleted;

	}

	if ( 'get' === $action ) {

		// Devolver el valor actualizado.
		return $current_value;

	}
}


function handleScreen() {

    if ( isset( $_GET['delete-api_key'] ) ) {
        cfact_ld_api_key_mannger( 'delete' );
        wp_redirect( admin_url( 'admin.php?page=course_factory_integration' ) );
        exit;
    }

	if ( isset( $_GET['set-api_key'] ) && isset( $_GET['api-key'] ) && ! empty( $_GET['api-key'] ) ) {


		$api_key_data    = sanitize_text_field( wp_unslash( $_GET['api-key'] ) );
		$keepme_informed = isset( $_GET['keepme-informed'] ) ? sanitize_text_field( wp_unslash( $_GET['keepme-informed'] ) ) : 'false';
	
		if ( update_option( 'cfact_keepme_informed', $keepme_informed ) ) {
			add_option( 'cfact_keepme_informed', $keepme_informed );
		}
	
		cfact_ld_api_key_mannger( 'add', $api_key_data );
	
		cfact_integration_send_stadistic( 'set-apikey' );
	
		$url  = 'https://coursefactory.reevolutiva.cl/?fluentcrm=1&route=contact&hash=34cf89d2-797e-4174-ba3d-411b75ff24e6';
		$args = cfact_get_client_data();
	
		if ( $keepme_informed ) {
			$request = wp_remote_post( $url, $args );
			$body    = wp_remote_retrieve_body( $request );
			$body    = json_decode( $body );
		}

		if ( !$keepme_informed ) {

			$args = array(
				'header' => array( 'Accept' => '*/*' ),
				'body'   => array(
					'first_name'    => get_bloginfo( 'url' ),
					'last_name'     => "",
					'email'         => "",
					'tag[]'         => '2',
					'list[]'        => '3',
					'status'        => 'subcribed',
				),
			);

			$request = wp_remote_post( $url, $args );
			$body    = wp_remote_retrieve_body( $request );
			$body    = json_decode( $body );
		}

		wp_redirect( admin_url( 'admin.php?page=course_factory_integration' ) );
        exit;
	}
	
}

add_action( 'admin_init', 'handleScreen' );